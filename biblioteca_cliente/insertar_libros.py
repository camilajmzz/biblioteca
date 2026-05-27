import requests

API_URL = "http://localhost/biblioteca/api/libros"

# Lista de libros que quieres añadir
libros = [
    {"titulo": "Cien años de soledad", "autor": "Gabriel García Márquez", "anio": 1967},
    {"titulo": "El Principito", "autor": "Antoine de Saint-Exupéry", "anio": 1943},
    {"titulo": "1984", "autor": "George Orwell", "anio": 1949},
    {"titulo": "Don Quijote de la Mancha", "autor": "Miguel de Cervantes", "anio": 1605},
    {"titulo": "La sombra del viento", "autor": "Carlos Ruiz Zafón", "anio": 2001},
]

for libro in libros:
    r = requests.post(API_URL, json=libro)
    print("Insertado:", r.json())
