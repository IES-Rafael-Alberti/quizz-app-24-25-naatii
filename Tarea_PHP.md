### **Tarea: Aplicación de Cuestionario en PHP**

**Objetivo:**
Crear una aplicación funcional que permita a los usuarios realizar cuestionarios, recibir retroalimentación inmediata y registrar los resultados en una base de datos. Se integrarán funcionalidades clave como autenticación de usuarios, gestión de preguntas y respuestas dinámicas desde una base de datos.

**Instrucciones Generales:**

1. **Configuración Inicial (30 minutos):**

   - Configura un servidor PHP (Docker, XAMPP, etc.).
   - Crea una base de datos con las siguientes tablas básicas:
     - **Usuarios:** `user_id`, `username`, `password` (encriptada).
     - **Cuestionarios:** `quiz_id`, `title`, `description`.
     - **Preguntas:** `question_id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`.

2. **Autenticación y Gestión de Sesiones (30 minutos):**

   - Implementa un sistema de registro e inicio de sesión para usuarios.
   - Utiliza sesiones para gestionar el inicio y cierre de sesión.
   - Almacena datos básicos como el nombre de usuario en las sesiones.

3. **Creación y Gestión de Cuestionarios (60 minutos):**

   - Desarrolla una página para que los usuarios con permisos (instructores) creen cuestionarios y añadan preguntas.
   - Implementa un CRUD básico (Crear, Leer, Actualizar, Eliminar) para gestionar cuestionarios y preguntas.

4. **Realización de Cuestionarios (60 minutos):**

   - Diseña una interfaz para que los estudiantes realicen cuestionarios.
   - Recupera preguntas dinámicamente desde la base de datos.
   - Valida las respuestas y proporciona retroalimentación inmediata.
   - Registra las puntuaciones en la base de datos.

5. **Evaluación y Seguimiento (30 minutos):**
   - Muestra un resumen de las respuestas correctas/incorrectas tras completar un cuestionario.
   - Incluye estadísticas básicas como la puntuación media y el número de intentos por cuestionario.

**Aspectos Clave para Evaluar:**

- Funcionalidad básica (autenticación, cuestionarios, retroalimentación).
- Uso correcto de PHP (POO, manejo de sesiones, superglobales).
- Seguridad (encriptación de contraseñas, prevención de inyecciones SQL).
- Diseño de la base de datos y consultas eficientes.
- Interfaz de usuario intuitiva.
