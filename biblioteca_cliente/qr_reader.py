import cv2
from pyzbar.pyzbar import decode

def leer_qr():
    cam = cv2.VideoCapture(0)

    while True:
        ret, frame = cam.read()
        if not ret:
            break

        for qr in decode(frame):
            data = qr.data.decode("utf-8")
            cam.release()
            cv2.destroyAllWindows()
            return data

        cv2.imshow("Escanea el QR", frame)

        if cv2.waitKey(1) == 27:  # ESC
            break

    cam.release()
    cv2.destroyAllWindows()
    return None
