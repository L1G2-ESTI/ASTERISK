import sys, smtplib
from email.mime.text import MIMEText


def sendMail(isTo, isFrom, argent, nArgent):
    message = MIMEText('')
    message['Subject'] = f'''
        Vous avez reçu {argent} Ar venant de {isFrom}
        Vous nouveau solde est donc de {nArgent} Ar
    '''

    message['From'] = 'amada.rktvo@gmail.com'
    message['To'] = isTo

    server = smtplib.SMTP('smtp.gmail.com:587')
    server.starttls()
    server.login('amada.rktvo@gmail.com','Diamondra_10')
    server.send_message(message)
    server.quit()


sendMail(sys.argv[1], sys.argv[2], sys.argv[3], sys.argv[4])
