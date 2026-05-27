import tkinter as tk
from estilos import aplicar_estilos
from login import LoginWindow
from libros import LibrosWindow

def start_app():
    root = tk.Tk()
    aplicar_estilos()  # Configura el nuevo diseño moderno

    def on_login_success(usuario):
        root.destroy()
        open_libros(usuario)

    LoginWindow(root, on_login_success)
    root.mainloop()

def open_libros(usuario):
    root = tk.Tk()
    aplicar_estilos()  # Configura el nuevo diseño moderno
    LibrosWindow(root, usuario)
    root.mainloop()

if __name__ == "__main__":
    start_app()