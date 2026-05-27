import tkinter as tk
from tkinter import ttk, messagebox
from api import login

class LoginWindow:
    def __init__(self, root, on_login_success):
        self.root = root
        self.on_login_success = on_login_success

        root.title("Login Biblioteca")
        root.geometry("400x450")  # Tamaño fijo elegante
        root.resizable(False, False)
        root.configure(background="#F4F6F9")

        # Tarjeta contenedora blanca central
        card = ttk.Frame(root, padding=30, style="Card.TFrame")
        card.place(relx=0.5, rely=0.5, anchor="center", width=340, height=380)

        # Título
        ttk.Label(card, text="¡Bienvenido de nuevo!", style="Titulo.TLabel", justify="center").pack(pady=(10, 20))

        # Campo Email
        ttk.Label(card, text="Correo electrónico", style="Muted.TLabel").pack(anchor="w", pady=(0, 5))
        self.email_entry = ttk.Entry(card, width=30)
        self.email_entry.pack(fill="x", pady=(0, 15))

        # Campo Contraseña
        ttk.Label(card, text="Contraseña", style="Muted.TLabel").pack(anchor="w", pady=(0, 5))
        self.pass_entry = ttk.Entry(card, show="*", width=30)
        self.pass_entry.pack(fill="x", pady=(0, 25))

        # Botón
        btn_login = ttk.Button(card, text="Iniciar sesión", command=self.do_login)
        btn_login.pack(fill="x", ipady=4)

    def do_login(self):
        email = self.email_entry.get()
        password = self.pass_entry.get()

        result = login(email, password)

        if result.get("ok"):
            messagebox.showinfo("Éxito", "Login correcto")
            self.on_login_success(result["usuario"])
        else:
            messagebox.showerror("Error", "Credenciales incorrectas")