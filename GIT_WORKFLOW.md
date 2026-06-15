# Flujo de Trabajo Git del Proyecto

## Estructura de Ramas

El proyecto utiliza la siguiente estructura de ramas:

```text
master
│
├── develop
│
├── feature/backend
├── feature/procesos
└── feature/frontend
```

### Descripción

| Rama             | Propósito                                                   |
| ---------------- | ----------------------------------------------------------- |
| master           | Versión estable del sistema                                 |
| develop          | Integración de cambios antes de pasar a producción          |
| feature/backend  | Desarrollo del backend y base de datos                      |
| feature/procesos | Desarrollo de la lógica de negocio y procesos de titulación |
| feature/frontend | Desarrollo de interfaces y experiencia de usuario           |

---

# Responsables

| Integrante (Nombre) | Rama Asignada | Rol / Tarea |
| :--- | :--- | :--- |
| **GUIDO** | `feature/backend` | Desarrollo del backend y base de datos |
| **CESAR** | `feature/procesos` | Desarrollo de la lógica de negocio y procesos de titulación |
| **CIRILO** | `feature/frontend` | Desarrollo de interfaces y experiencia de usuario |

---

# Reglas del Proyecto

> [!WARNING]
> ### 🚨 PROHIBIDO PUSHEAR A MASTER 🚨
> Está **total y terminantemente prohibido** realizar commits o pushes directos a la rama `master`.
>
> Todos los cambios deben pasar obligatoriamente por Pull Request y validarse en la rama `develop` antes de integrarse.

---

## No trabajar directamente en master

Está prohibido realizar commits o pushes directos a la rama:

```bash
master
```

Todos los cambios deben pasar por Pull Request.

---

## No trabajar directamente en develop

La rama develop se utiliza únicamente para integrar cambios provenientes de las ramas feature.

---

# Flujo de Trabajo

## 1. Cambiar a la rama asignada

Backend:

```bash
git checkout feature/backend
```

Procesos:

```bash
git checkout feature/procesos
```

Frontend:

```bash
git checkout feature/frontend
```

---

## 2. Actualizar la rama antes de comenzar

```bash
git pull origin nombre-de-la-rama
```

Ejemplo:

```bash
git pull origin feature/backend
```

---

## 3. Realizar cambios

Modificar archivos según la tarea asignada.

---

## 4. Registrar cambios

```bash
git add .
git commit -m "Descripción del cambio realizado"
```

Ejemplo:

```bash
git commit -m "Implementación del módulo de estudiantes"
```

---

## 5. Subir cambios al repositorio

```bash
git push origin nombre-de-la-rama
```

Ejemplo:

```bash
git push origin feature/backend
```

---

## 6. Crear Pull Request

Una vez terminada una funcionalidad:

```text
feature/backend
        ↓
      develop
```

o

```text
feature/procesos
        ↓
      develop
```

o

```text
feature/frontend
        ↓
      develop
```

---

## 7. Revisión de Código

El líder del proyecto revisará:

* Calidad del código
* Funcionamiento
* Cumplimiento de requisitos
* Posibles errores

Solo después de la aprobación se realizará el Merge.

---

## 8. Paso a Producción

Cuando los cambios en develop hayan sido probados correctamente:

```text
develop
   ↓
master
```

mediante un Pull Request.

---

# Buenas Prácticas

* Realizar commits pequeños y frecuentes.
* Escribir mensajes claros en los commits.
* Mantener actualizada la rama asignada.
* No modificar archivos de otros módulos sin coordinación.
* Resolver conflictos antes de crear un Pull Request.
* Probar los cambios antes de subirlos.

---

# Comandos Útiles

Ver ramas:

```bash
git branch
```

Ver estado:

```bash
git status
```

Actualizar cambios:

```bash
git pull
```

Subir cambios:

```bash
git push
```

Cambiar de rama:

```bash
git checkout nombre-rama
```

Historial de commits:

```bash
git log --oneline
```

---

# Objetivo

Mantener un desarrollo ordenado, evitar conflictos entre integrantes y proteger la estabilidad de la rama principal del proyecto.