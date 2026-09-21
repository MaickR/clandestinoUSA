# Setup del entorno de agentes — antes de escribir la primera línea

Orden recomendado. Todo lo que sigue asume que ya copiaste los archivos de este paquete a la raíz del repo `clandestinoUSA`.

## 1. Instalar Spec Kit (columna vertebral del flujo de trabajo)

```bash
uvx --from git+https://github.com/github/spec-kit.git specify init --here
```

Esto agrega comandos `/speckit.constitution`, `/speckit.specify`, `/speckit.plan`, `/speckit.tasks`, `/speckit.implement` disponibles en Copilot Chat. Úsalos así para cada módulo nuevo (gift cards, loyalty, wine shop, etc.):

1. `/speckit.constitution` — una sola vez al inicio; pégale el contenido de `AGENTS.md` + `docs/ESTANDARES-DE-CODIGO.md` como base.
2. `/speckit.specify` — describe el módulo que vas a construir (ej. "sistema de tarjetas de regalo digitales de 50 a 500 USD con Stripe").
3. `/speckit.plan` — deja que el agente proponga el plan técnico dentro de tu stack ya fijado.
4. `/speckit.tasks` — desglose en tareas concretas.
5. `/speckit.implement` — ejecución.

No lo uses para cambios triviales (un texto, un color) — es para features completas.

## 2. Fusionar los principios Karpathy en AGENTS.md

Ya están incorporados en la sección "Reglas no negociables" de `AGENTS.md` de este paquete, adaptados de https://github.com/multica-ai/andrej-karpathy-skills. No necesitas instalar nada aparte — si quieres el texto original en inglés como referencia:

```bash
curl -s https://raw.githubusercontent.com/multica-ai/andrej-karpathy-skills/main/CLAUDE.md
```

## 3. Instalar solo 4 skills de mattpocock/skills

No instales las 41 — de ese repositorio, solo estas encajan con un proyecto solo-dev apoyado fuertemente en IA:

```bash
npx skills add mattpocock/skills --only tdd,diagnosing-bugs,codebase-design,grilling
```

(Si el flag `--only` no existe en la versión del CLI que te instale, usa el comando interactivo `/setup-matt-pocock-skills` una vez estén copiadas y selecciona manualmente esas cuatro.) Déjalas en `.agents/skills/` para que sean visibles a cualquier agente, no en `.claude/skills/`.

## 4. Skills propias de este proyecto

Ya incluidas en `.agents/skills/`:
- `auditoria-assets-marca` — corre esta primero (colores, tipografías, imágenes).
- `auditoria-estructura-actual` — corre esta segunda (páginas, secciones, convenciones de código, lógica PHP existente).
- `refactorizar-seccion-actual` — úsala una vez por sección/página que refactorices, siguiendo el orden de `docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md`.

## 5. skills.sh — solo para necesidades puntuales futuras

No instales nada de ahí "por si acaso". Cuando surja una necesidad concreta (ej. una skill de auditoría SEO, una de generación de PDFs para gift cards), busca ahí primero antes de escribir una desde cero — pero cada instalación debe justificarse por una tarea real, no por catálogo.

## 6. MCP

`.vscode/mcp.json` ya trae Playwright (QA visual/accesibilidad) y Stripe (pagos) configurados. Al abrir el proyecto en VS Code, Copilot te pedirá la Stripe secret key la primera vez — usa una Restricted API Key desde el dashboard de Stripe, no la clave maestra de la cuenta.

Cuando llegues al módulo de base de datos (gift cards, puntos), agrega esto al mismo archivo, dentro de `"servers"`:

```json
"mysql": {
  "type": "stdio",
  "command": "npx",
  "args": ["-y", "@benborla29/mcp-server-mysql"],
  "env": {
    "MYSQL_HOST": "127.0.0.1",
    "MYSQL_PORT": "3306",
    "MYSQL_USER": "tu_usuario",
    "MYSQL_PASS": "tu_password",
    "MYSQL_DB": "tu_base_de_datos"
  }
}
```

Es de solo lectura por defecto (hay que habilitar escritura explícitamente con variables `ALLOW_INSERT_OPERATION`, etc.) — buena idea dejarlo así mientras el agente todavía está explorando el esquema.

## 7. Primer prompt real a correr

Una vez todo lo anterior está en el repo, el primer prompt en Copilot Chat (modo agente) es simplemente:

> Lee AGENTS.md, docs/ESTANDARES-DE-CODIGO.md y docs/MAPA-DEL-SITIO-Y-ORDEN-DE-CONSTRUCCION.md completos. Después usa la skill auditoria-assets-marca y luego auditoria-estructura-actual sobre el repo actual, y genera ambos inventarios.

Eso te da el inventario de marca y de estructura antes de tocar una sola página.
