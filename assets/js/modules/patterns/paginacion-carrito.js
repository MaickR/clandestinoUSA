/** Proyección pura; nunca excluye líneas del cálculo global. Página basada en uno. */
export function paginarCarrito(total, pagina = 1) {
  if (!Number.isSafeInteger(total) || total < 0 || !Number.isSafeInteger(pagina)) throw new TypeError("Paginación inválida.");
  const paginas = Math.max(1, Math.ceil(total / 10));
  const actual = Math.max(1, Math.min(paginas, pagina));
  return { pagina: actual, paginas, inicio: (actual - 1) * 10, fin: Math.min(total, actual * 10), total };
}
