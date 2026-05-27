import tkinter as tk
from tkinter import ttk

def aplicar_estilos():
    style = ttk.Style()
    # Usar el tema 'clam' como base para poder personalizar bordes y colores
    style.theme_use("clam")

    # --- PALETA DE COLORES ---
    COLOR_FONDO = "#F4F6F9"       # Gris muy claro azulado
    COLOR_CARD = "#FFFFFF"        # Blanco puro para contenedores
    COLOR_PRIMARIO = "#2563EB"    # Azul moderno (Material)
    COLOR_PRIMARIO_HOVER = "#1D4ED8"
    COLOR_TEXTO = "#1E293B"       # Gris oscuro (casi negro)
    COLOR_TEXTO_MUTED = "#64748B" # Gris secundario
    COLOR_BORDE = "#E2E8F0"       # Gris claro para líneas y bordes

    # --- ESTILOS GENERALES ---
    style.configure(".", background=COLOR_FONDO, foreground=COLOR_TEXTO, font=("Segoe UI", 10))
    
    # --- CONTENEDORES (FRAMES) ---
    style.configure("TFrame", background=COLOR_FONDO)
    style.configure("Card.TFrame", background=COLOR_CARD, relief="flat")
    
    # --- ETIQUETAS (LABELS) ---
    style.configure("TLabel", background=COLOR_FONDO, foreground=COLOR_TEXTO)
    style.configure("Card.TLabel", background=COLOR_CARD, foreground=COLOR_TEXTO)
    style.configure("Titulo.TLabel", font=("Segoe UI", 16, "bold"), foreground=COLOR_PRIMARIO)
    style.configure("Subtitulo.TLabel", font=("Segoe UI", 12, "bold"), foreground=COLOR_TEXTO)
    style.configure("Muted.TLabel", font=("Segoe UI", 9), foreground=COLOR_TEXTO_MUTED)

    # --- BOTONES ---
    # Botón Primario (Azul)
    style.configure("TButton", 
                    background=COLOR_PRIMARIO, 
                    foreground="white", 
                    font=("Segoe UI", 10, "bold"),
                    padding=(15, 8), 
                    borderwidth=0,
                    focuscolor="none")
    style.map("TButton", 
              background=[("active", COLOR_PRIMARIO_HOVER), ("pressed", "#1E40AF")])

    # Botón Secundario / Limpiar (Gris/Blanco)
    style.configure("Secundario.TButton", 
                    background=COLOR_BORDE, 
                    foreground=COLOR_TEXTO, 
                    font=("Segoe UI", 10),
                    padding=(12, 8))
    style.map("Secundario.TButton", 
              background=[("active", "#CBD5E1")])

    # Botón de Acción Especial (Verde para Préstamos/Devoluciones)
    style.configure("Accion.TButton", 
                    background="#10B981", 
                    foreground="white", 
                    font=("Segoe UI", 10, "bold"))
    style.map("Accion.TButton", 
              background=[("active", "#059669")])

    # --- ENTRADAS DE TEXTO (ENTRIES) ---
    style.configure("TEntry", 
                    fieldbackground=COLOR_CARD, 
                    bordercolor=COLOR_BORDE, 
                    lightcolor=COLOR_BORDE, 
                    darkcolor=COLOR_BORDE,
                    padding=8)
    
    # --- SEPARADORES ---
    style.configure("TSeparator", background=COLOR_BORDE)