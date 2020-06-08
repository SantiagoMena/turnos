#!/bin/bash
#30 4 * * * /home/uczb2xgcy3kb/public_html/ingreso/cron/reminder.sh
# echo 'Cron Reminder - ' >> respuestas.txt
echo $(date '+%d/%m/%Y %H:%M:%S') >> respuestas.txt
echo "" >> respuestas.txt
curl -v -sS http://turnos.desligar.me/turno/recordar >> respuestas.txt
echo "" >> respuestas.txt