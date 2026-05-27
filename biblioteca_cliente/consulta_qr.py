from qr_reader import leer_qr
from api import consultar_libro

id_libro = leer_qr()

if id_libro:
    info = consultar_libro(id_libro)
    print("Libro encontrado:")
    print(info)
else:
    print("No se detectó ningún QR")
