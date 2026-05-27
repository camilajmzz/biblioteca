import tkinter as tk
from tkinter import ttk
from api import get_libros
from prestamos import PrestamosWindow

class LibrosWindow:
    def __init__(self, root, usuario):
        self.root = root
        self.usuario = usuario

        root.title("Catálogo de libros")
        root.geometry("700x600")
        root.configure(background="#F4F6F9")

        # Frame Principal
        frame = ttk.Frame(root, padding=25)
        frame.pack(fill="both", expand=True)

        # Encabezado con saludo
        ttk.Label(frame, text=f"Hola, {usuario['nombre']} 👋", style="Titulo.TLabel").pack(anchor="w", pady=(0, 15))

        # ============================
        # BUSCADOR (Panel superior)
        # ============================
        buscador_frame = ttk.Frame(frame)
        buscador_frame.pack(fill="x", pady=(0, 15))

        self.buscar_entry = ttk.Entry(buscador_frame, width=40)
        self.buscar_entry.pack(side="left", fill="x", expand=True, padx=(0, 10))
        # Añadir un texto de ayuda (placeholder) provisional si deseas, o dejarlo limpio
        
        btn_buscar = ttk.Button(buscador_frame, text="Buscar", command=self.buscar_libros)
        btn_buscar.pack(side="left", padx=5)
        
        btn_limpiar = ttk.Button(buscador_frame, text="Limpiar", style="Secundario.TButton", command=self.cargar_libros)
        btn_limpiar.pack(side="left", padx=5)

        # ============================
        # LISTA DE LIBROS
        # ============================
        # Contenedor para la lista y su scrollbar
        list_container = ttk.Frame(frame)
        list_container.pack(fill="both", expand=True, pady=10)

        # Estilización manual del Listbox para que luzca moderno
        self.listbox = tk.Listbox(
            list_container, 
            width=60, 
            height=15, 
            font=("Segoe UI", 11),
            background="#FFFFFF",
            foreground="#1E293B",
            selectbackground="#2563EB",
            selectforeground="#FFFFFF",
            highlightthickness=1,
            highlightbackground="#E2E8F0",
            bd=0,
            activestyle="none"
        )
        
        scrollbar = ttk.Scrollbar(list_container, orient="vertical", command=self.listbox.yview)
        self.listbox.configure(yscrollcommand=scrollbar.set)
        
        self.listbox.pack(side="left", fill="both", expand=True)
        scrollbar.pack(side="right", fill="y")

        # ============================
        # BOTONES INFERIORES
        # ============================
        botones_frame = ttk.Frame(frame)
        botones_frame.pack(fill="x", pady=(15, 0))

        ttk.Button(botones_frame, text="🔄 Actualizar Lista", style="Secundario.TButton", command=self.cargar_libros).pack(side="left")
        ttk.Button(botones_frame, text="📚 Gestión de Préstamos", style="Accion.TButton", command=self.abrir_prestamos).pack(side="right")

        self.cargar_libros()

    def cargar_libros(self):
        self.listbox.delete(0, tk.END)
        self.buscar_entry.delete(0, tk.END)
        self.libros = get_libros()

        for libro in self.libros:
            estado = "🟢 Disponible" if libro["disponible"] else "🔴 Prestado"
            self.listbox.insert(tk.END, f" #{libro['id']}  -  {libro['titulo']}   [{estado}]")

    def buscar_libros(self):
        texto = self.buscar_entry.get().lower().strip()
        self.listbox.delete(0, tk.END)

        for libro in self.libros:
            if (texto in libro["titulo"].lower() or
                texto in libro["autor"].lower() or
                texto == str(libro["id"])):
                
                estado = "🟢 Disponible" if libro["disponible"] else "🔴 Prestado"
                self.listbox.insert(tk.END, f" #{libro['id']}  -  {libro['titulo']}   [{estado}]")

    def abrir_prestamos(self):
        # Pasamos la ventana raíz actual por si necesitas manejar jerarquías en Toplevel
        PrestamosWindow(self.usuario)