---
applyTo: "**/*.php"
---

# PHP — reglas obligatorias

- Arquitectura en capas: Controllers (sin lógica de negocio) → Services (lógica de negocio) → Repositories (acceso a datos) → Models (entidades) → Views (solo presentación).
- PSR-12 en estilo, PSR-4 en autoloading (Composer).
- Seguridad, sin excepción: prepared statements/PDO en toda consulta SQL — nunca concatenar variables · `htmlspecialchars($valor, ENT_QUOTES, 'UTF-8')` en todo output a HTML · token CSRF en formularios POST/PUT/DELETE · `password_hash()` con `PASSWORD_ARGON2ID` o `PASSWORD_BCRYPT` — nunca MD5/SHA1 · cookies de sesión con `HttpOnly`, `Secure`, `SameSite=Strict`.
- Validar MIME real (`finfo_file`) en cualquier upload; guardar fuera del webroot.
- Nunca exponer stack traces ni mensajes técnicos de error en producción — página de error amigable + log interno.
- Variables de entorno en `.env` (nunca hardcodeadas ni commiteadas); mantener `.env.example` actualizado.
- Código y comentarios en español; PHPDoc (`@param`, `@return`, `@throws`) en toda función/clase pública.
- Nomenclatura: `camelCase` en funciones/variables, `PascalCase` en clases, `UPPER_SNAKE_CASE` en constantes.
