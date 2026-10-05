// ESLint (Flat Config): solo código nuevo y tooling.
// El JS legacy (assets/js/*.js, sw.js, *.min.js) se lintea cuando se migre.
import js from "@eslint/js";
import globals from "globals";

export default [
  {
    ignores: [
      "node_modules/**",
      "assets/js/dist/**",
      "**/*.min.js",
    ],
  },
  {
    files: ["assets/js/main.js", "assets/js/style-guide.js", "assets/js/modules/**/*.js"],
    ...js.configs.recommended,
    languageOptions: {
      ecmaVersion: 2020,
      sourceType: "module",
      globals: { ...globals.browser },
    },
  },
  {
    files: ["**/*.mjs"],
    ...js.configs.recommended,
    languageOptions: {
      ecmaVersion: "latest",
      sourceType: "module",
      globals: { ...globals.node },
    },
  },
];
