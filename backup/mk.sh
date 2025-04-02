REPO_DIR_API=$(pwd)
#!/bin/bash

echo "MySQL ma'lumotlar bazasining zaxirasi olinmoqda..."

# Hozirgi sana va vaqtni olish
now=$(date +%Y-%m-%d_%H-%M-%S)

# Skriptning turgan joyini topish
SCRIPT_DIR="$(dirname "$(realpath "$0")")"
#REPO_DIR_API="$(dirname "$SCRIPT_DIR")"

# .env faylini yuklash
ENV_FILE="$REPO_DIR_API/.env"
if [ -f "$ENV_FILE" ]; then
    export $(grep -v '^#' "$ENV_FILE" | xargs)
else
    echo ".env fayli topilmadi: $ENV_FILE"
    exit 1
fi

# Oldindan belgilangan qiymatlar
PROJECT_NAME=${DOCKER_PROJECT_NAME}
DOCKERFILE_API="$REPO_DIR_API/docker-compose.yml"
DB_NAME_API=${DOCKER_PROJECT_NAME}
MYSQL_PASSWORD=${DB_PASSWORD}
MYSQL_USER=${DB_USERNAME}
DB_DATABASE=${DB_DATABASE}
OUTPUT_FILE_API="$REPO_DIR_API/backup/$PROJECT_NAME-$now.sql"
TAR_FILE_API="$REPO_DIR_API/backup/$PROJECT_NAME-$now.tar.gz"

# API bazasini zaxiralash
echo "Docker orqali zaxiralash boshlandi..."

# 1. Faqat uchta jadvalni (exam_student, exam_student_answer, exam_atudent_answer_sub_question) backup qilish
# mysqldump -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" --single-transaction --quick --skip-lock-tables \
#     "$DB_DATABASE" >"$OUTPUT_FILE_API"

docker compose -f $DOCKERFILE_API exec mysql sh -c "mysqldump -uroot -p$DB_PASS_API $DB_NAME_API" >$OUTPUT_FILE_API

if [ $? -eq 0 ]; then
    echo "Zaxira muvaffaqiyatli olindi: $OUTPUT_FILE_API"
else
    echo "Zaxira jarayonida xatolik yuz berdi."
    exit 1
fi

# Faylni siqish
echo "Zaxira faylini siqish boshlandi..."
tar -cvzf $TAR_FILE_API $OUTPUT_FILE_API

if [ $? -eq 0 ]; then
    echo "Fayl siqildi: $TAR_FILE_API"
else
    echo "Siqish jarayonida xatolik yuz berdi."
    exit 1
fi

# Asl SQL faylini o'chirish
rm $OUTPUT_FILE_API

# Telegram API orqali faylni yuborish
echo "Fayl Telegramga yuborilmoqda..."
API_TOKEN="5216479765:AAEAT2C19Rev5JMBYqhPj_GyTNSVm1-BNYc"
CHAT_ID="813225336"

# Fayl hajmini tekshirish
FILE_SIZE=$(du -m "$TAR_FILE_API" | cut -f1)

if ((FILE_SIZE > 49)); then
    echo "Fayl hajmi katta ($FILE_SIZE MB), bo'laklarga bo'linmoqda..."

    # Faylni 49MB bo‘laklarga ajratish
    split -b 49M "$TAR_FILE_API" "${TAR_FILE_API}_part_"

    # Har bir bo‘lakni Telegram'ga yuborish
    for file in ${TAR_FILE_API}_part_*; do
        curl -F chat_id="$CHAT_ID" -F document=@$file "https://api.telegram.org/bot$API_TOKEN/sendDocument"
    done

    # Bo‘laklarni o‘chirish
    rm ${TAR_FILE_API}_part_*
else
    # Agar 50MB dan kichik bo‘lsa, to‘g‘ridan-to‘g‘ri yuborish
    curl -F chat_id="$CHAT_ID" -F document=@$TAR_FILE_API "https://api.telegram.org/bot$API_TOKEN/sendDocument"
fi

if [ $? -eq 0 ]; then
    echo "Fayl Telegramga muvaffaqiyatli yuborildi."
else
    echo "Telegramga yuborishda xatolik yuz berdi."
    exit 1
fi

# Siqilgan faylni o'chirish (agar kerak bo'lsa)
rm $TAR_FILE_API

echo "Zaxira jarayoni yakunlandi."
