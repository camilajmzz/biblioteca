import requests

API_URL = "http://localhost/biblioteca/api"

def login(email, password):
    r = requests.post(f"{API_URL}/login", json={
        "email": email,
        "password": password
    })
    return r.json()

def get_libros():
    r = requests.get(f"{API_URL}/libros")
    return r.json()

def crear_prestamo(id_usuario, id_libro):
    r = requests.post(f"{API_URL}/prestamos", json={
        "id_usuario": id_usuario,
        "id_libro": id_libro
    })
    return r.json()

def devolver_prestamo(id_prestamo):
    r = requests.put(f"{API_URL}/prestamos/{id_prestamo}/devolver")
    return r.json()

def get_prestamos():
    r = requests.get(f"{API_URL}/prestamos")
    return r.json()
