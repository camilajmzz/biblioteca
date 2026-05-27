import tkinter as tk
from tkinter import ttk, messagebox
from api import crear_prestamo, devolver_prestamo, get_prestamos
from qr_reader import leer_qr

class PrestamosWindow:
    def __init__(self, usuario):
        self.usuario = usuario

        self.root = tk.Toplevel()
        self.root.title("Gestión de Préstamos")
        self.root.geometry("450x650")
        self.root.configure(background="#F4F6F9")

        # Contenedor general con scroll si hiciera falta (en este caso cabe justo)
        main_frame = ttk.Frame(self.root, padding=20)
        main_frame.pack(fill="both", expand=True)

        ttk.Label(main_frame, text="Gestión de Préstamos", style="Titulo.TLabel").pack(pady=(0, 20), anchor="center")

        # ============================
        # BLOQUE: REGISTRAR PRÉSTAMO
        # ============================
        card_prestamo = ttk.Frame(main_frame, padding=15, style="Card.TFrame")
        card_prestamo.pack(fill="x", pady=(0, 15))

        ttk.Label(card_prestamo, text="📥 Registrar Préstamo", style="Subtitulo.TLabel", background="white").pack(anchor="w", pady=(0, 10))
        
        ttk.Label(card_prestamo, text="ID Libro", style="Muted.TLabel", background="white").pack(anchor="w")
        self.id_libro_entry = ttk.Entry(card_prestamo)
        self.id_libro_entry.pack(fill="x", pady=(0, 10))

        btn_p1 = ttk.Button(card_prestamo, text="Confirmar Préstamo", command=self.registrar_prestamo)
        btn_p1.pack(fill="x", pady=2)
        
        btn_p2 = ttk.Button(card_prestamo, text="📷 Escanear QR", style="Secundario.TButton", command=self.qr_prestamo)
        btn_p2.pack(fill="x", pady=2)


        # ============================
        # BLOQUE: REGISTRAR DEVOLUCIÓN
        # ============================
        card_devolucion = ttk.Frame(main_frame, padding=15, style="Card.TFrame")
        card_devolucion.pack(fill="x", pady=10)

        ttk.Label(card_devolucion, text="📤 Registrar Devolución", style="Subtitulo.TLabel", background="white").pack(anchor="w", pady=(0, 10))
        
        ttk.Label(card_devolucion, text="ID Préstamo", style="Muted.TLabel", background="white").pack(anchor="w")
        self.id_prestamo_entry = ttk.Entry(card_devolucion)
        self.id_prestamo_entry.pack(fill="x", pady=(0, 10))

        btn_d1 = ttk.Button(card_devolucion, text="Confirmar Devolución", style="Accion.TButton", command=self.registrar_devolucion)
        btn_d1.pack(fill="x", pady=2)
        
        btn_d2 = ttk.Button(card_devolucion, text="📷 Escanear QR", style="Secundario.TButton", command=self.qr_devolucion)
        btn_d2.pack(fill="x", pady=2)

    def registrar_prestamo(self):
        id_libro = self.id_libro_entry.get()
        if not id_libro.isdigit():
            messagebox.showerror("Error", "ID inválido")
            return

        resp = crear_prestamo(self.usuario["id"], int(id_libro))
        if resp.get("ok"):
            messagebox.showinfo("Éxito", "Préstamo registrado correctamente")
            self.id_libro_entry.delete(0, tk.END)
        else:
            messagebox.showerror("Error", resp.get("error", "Error desconocido"))

    def registrar_devolucion(self):
        id_prestamo = self.id_prestamo_entry.get()
        if not id_prestamo.isdigit():
            messagebox.showerror("Error", "ID inválido")
            return

        resp = devolver_prestamo(int(id_prestamo))
        if resp.get("ok"):
            messagebox.showinfo("Éxito", "Préstamo devuelto correctamente")
            self.id_prestamo_entry.delete(0, tk.END)
        else:
            messagebox.showerror("Error", resp.get("error", "Error desconocido"))

    def qr_prestamo(self):
        id_libro = leer_qr()
        if id_libro:
            resp = crear_prestamo(self.usuario["id"], int(id_libro))
            if resp.get("ok"):
                messagebox.showinfo("Éxito", f"Préstamo registrado (Libro {id_libro})")
            else:
                messagebox.showerror("Error", resp.get("error", "Error desconocido"))

    def qr_devolucion(self):
        id_libro = leer_qr()
        if not id_libro:
            messagebox.showerror("Error", "No se leyó ningún QR")
            return

        prestamos = get_prestamos()
        prestamo_activo = next(
            (p for p in prestamos
             if str(p.get("id_libro")) == str(id_libro)
             and p.get("fecha_devolucion") is None),
            None
        )

        if not prestamo_activo:
            messagebox.showerror("Error", f"No hay préstamo activo para el libro {id_libro}")
            return

        resp = devolver_prestamo(int(prestamo_activo["id"]))
        if resp.get("ok"):
            messagebox.showinfo("Éxito", f"Devolución registrada\n(Libro {id_libro}, Préstamo {prestamo_activo['id']})")
        else:
            messagebox.showerror("Error", resp.get("error", "Error desconocido"))