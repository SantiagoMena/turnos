#!/bin/bash
#30 4 * * * /home/uczb2xgcy3kb/public_html/ingreso/cron/reminder.sh
# echo 'Cron Reminder - ' >> respuestas.txt
echo $(date '+%d/%m/%Y %H:%M:%S') >> respuestas.txt
echo "" >> respuestas.txt
curl -v -sS http://integrarips.com/ingreso/web/cita/recordar >> respuestas.txt
echo "" >> respuestas.txt