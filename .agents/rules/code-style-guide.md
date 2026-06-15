---
trigger: always_on
---

# Bootstrap 5 UI Guidelines

## Framework y dependencias

* Utilizar exclusivamente componentes y utilidades oficiales de Bootstrap 5.
* Para iconografía, utilizar únicamente Bootstrap Icons.
* No incorporar otros frameworks CSS o librerías de iconos adicionales.

## Uso de componentes Card

* Utilizar las clases base de Bootstrap para `card`, `card-header` y `card-body` sin añadir clases utilitarias que modifiquen su apariencia predeterminada.
* No agregar clases como:

  * `.border-0`
  * `.shadow`
  * `.shadow-sm`
  * `.shadow-lg`
  * `.rounded-0`
  * `.rounded-*`
  * Cualquier otra clase destinada a alterar el estilo visual estándar del componente.

### Ejemplo correcto

```html
<div class="card">
    <div class="card-header">
        Título
    </div>
    <div class="card-body">
        Contenido
    </div>
</div>
```

### Ejemplo incorrecto

```html
<div class="card border-0 shadow rounded-3">
    <div class="card-header bg-light">
        Título
    </div>
    <div class="card-body text-dark">
        Contenido
    </div>
</div>
```

## Colores

* No utilizar colores fijos mediante clases utilitarias de Bootstrap.

* Evitar clases de fondo como:

  * `.bg-white`
  * `.bg-light`
  * `.bg-dark`
  * `.bg-black`
  * `.bg-*`

* Evitar clases de texto como:

  * `.text-white`
  * `.text-dark`
  * `.text-black`
  * `.text-muted`
  * `.text-*`

* La apariencia visual debe adaptarse automáticamente al tema global de la aplicación (claro u oscuro) sin forzar colores específicos en los componentes.

## Consistencia visual

* Mantener el aspecto predeterminado proporcionado por Bootstrap 5.
* Priorizar la simplicidad, consistencia y compatibilidad con futuros cambios de tema.
* Evitar personalizaciones innecesarias que modifiquen la experiencia visual estándar de Bootstrap.
