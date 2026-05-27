import requests

API_URL = "http://localhost/biblioteca/api/register"

usuarios = [
    {"nombre": "Admin", "email": "admin@biblioteca.com", "password": "1234", "tipo": "bibliotecario"},
    {"nombre": "Juan Pérez", "email": "juan@example.com", "password": "1234", "tipo": "usuario"},
    {"nombre": "María López", "email": "maria@example.com", "password": "1234", "tipo": "usuario"},
    {"nombre": "Carlos Ruiz", "email": "carlos@example.com", "password": "1234", "tipo": "usuario"},
    {"nombre": "Ana Torres", "email": "ana@example.com", "password": "1234", "tipo": "usuario"},
]

for u in usuarios:
    r = requests.post(API_URL, json=u)
    print("Insertado:", r.json())
