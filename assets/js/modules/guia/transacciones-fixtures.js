// Datos sintéticos exclusivos de Style Guide; nunca importar desde una página productiva.
export const productosEjemplo = [
  { id: "tabla", productoId: "tabla", nombre: "Cheese & charcuterie board", descripcion: "Sharing board · example portion", variante: "Board", precio: 3600, maximo: 6,
    imagen: "/assets/images/webp/gallery/tapas/the-clandestino-tapas-6.webp", alt: "Sharing board with cheese and cured meats" },
  { id: "vino", productoId: "pure-soul", nombre: "PURE SOUL", descripcion: "Photographed label · vintage unconfirmed", precio: 4500, maximo: 6, tipo: "vino", restringido: true,
    imagen: "/assets/images/webp/wines/PURE-SOUL.webp", alt: "PURE SOUL wine bottles",
    variantes: [{ id: "botella", nombre: "Bottle · size unconfirmed", precio: 4500 }, { id: "copa", nombre: "Glass · size unconfirmed", precio: 1200 }] },
];

/** Se generan solo al elegir el control de estrés; la muestra principal conserva dos líneas. */
export function coleccionEjemplo(cantidad) {
  if (![1, 2, 8, 20, 40].includes(cantidad)) throw new RangeError("Colección demo desconocida.");
  if (cantidad <= 2) return productosEjemplo.slice(0, cantidad).map((p) => ({ ...p }));
  return Array.from({ length: cantidad }, (_, indice) => {
    const base = productosEjemplo[indice % 2];
    return { ...base, id: `muestra-${indice + 1}`, cantidad: cantidad >= 20 ? 3 : 1,
      nombre: indice % 7 === 0 ? `A generously named sharing selection with an exceptionallylongdemonstrationproductname · layout ${indice + 1}` : `${base.nombre} · layout ${indice + 1}`,
      imagen: indice % 5 === 4 ? null : base.imagen,
      ...(indice % 13 === 7 ? { precio: 123456789, variantes: [], varianteId: null, descripcion: "Large amount stress · entirely synthetic" } : {}),
    };
  });
}

/** Servicio local abortable; no consulta códigos ni vigencias comerciales. */
export function consultarCodigoEjemplo(codigo, datos, { signal }) {
  return new Promise((resolver) => {
    if (signal.aborted) { resolver({ estado: "cancelado" }); return; }
    const temporizador = window.setTimeout(() => {
      const estados = { "DEMO-EXPIRED": "expirado", "DEMO-INELIGIBLE": "no-elegible", "DEMO-ERROR": "error" };
      const estado = codigo === "DEMO10" ? (datos.valido && datos.subtotal >= 5000 ? "aplicado" : "no-elegible") : estados[codigo] ?? "invalido";
      resolver({ estado, descuento: { codigo, importe: 1000, minimo: 5000 } });
    }, 500);
    signal.addEventListener("abort", () => { clearTimeout(temporizador); resolver({ estado: "cancelado" }); }, { once: true });
  });
}

const estado = (titulo, mensaje, siguiente, variante = "informacion") => ({ titulo, mensaje, siguiente, variante });

export const estadosEjemplo = {
  pedido: { nombre: "Take Away / order ahead", destino: "#w7-checkout", referencia: "DEMO-ORDER-001", estados: {
    iniciado: estado("Order started · demo", "Your example selection has not been submitted.", "Review items, quantities and fulfillment preferences."),
    pendiente: estado("Order request pending · demo", "Receipt and availability have not been confirmed.", "Check the request result before submitting another order."),
    recibido: estado("Order received · demo", "This fictional order shows the received state. No kitchen has been notified.", "Wait for a separate service or collection confirmation."),
    preparacion: estado("In preparation · demo", "A conceptual kitchen state, not a live preparation update.", "A future service will provide a confirmed collection update."),
    listo: estado("Ready for pickup · demo", "Illustrative collection status. Nothing is ready for collection in this preview.", "Review the collection details supplied with the real order.", "exito"),
    completado: estado("Order completed · demo", "A fictional completed operation; no real receipt exists.", "Review the order summary.", "exito"),
    cancelado: estado("Order cancelled · demo", "The example order is cancelled. Payment and refund outcomes must be checked separately.", "Review cancellation details before placing a new order.", "aviso"),
    rechazado: estado("Order not accepted · demo", "The restaurant could not accept this fictional request.", "Review the reason and any separate payment result.", "error"),
    disponibilidad: estado("Availability pending · demo", "Requested collection time and items are unconfirmed.", "Wait for an authoritative availability result."),
    error: estado("Order request failed · demo", "Your details are preserved. No real request was sent.", "Review your details and retry the local preview.", "error"),
  } },
  pago: { nombre: "Payment", destino: "#w7-pago", referencia: "DEMO-PAY-001", estados: {
    procesando: estado("Payment processing · demo", "This preview is displaying a processing state; no charge is running.", "Wait for the result. Do not start another payment."),
    exito: estado("Payment approved · simulation only", "An approved-result layout for the reviewed example amount. No funds moved and no final charge was authorized.", "Review the separate order, issuance or activation result.", "exito"),
    rechazado: estado("Payment declined · demo", "The example payment was not approved. Your order details remain available.", "Review the provider response before deciding whether to try again.", "error"),
    pendiente: estado("Payment pending · demo", "No final payment result is available.", "Check this operation before starting another payment.", "aviso"),
    expirado: estado("Payment session expired · demo", "The example session is no longer usable. An expired session is not proof that no charge occurred.", "Check the previous operation result before opening a new session.", "aviso"),
    error: estado("Payment service unavailable · demo", "The preview could not complete. The outcome needs verification.", "Check the operation result before attempting another payment.", "error"),
    desconocido: estado("Payment result unknown · demo", "A timeout does not establish whether a charge succeeded.", "Check the existing operation. Do not pay again while its result is unknown.", "aviso"),
    recuperacion: estado("Payment result recovered · demo", "This fictional lookup reports an approved example. It does not repeat a charge.", "Review the example receipt and separate fulfillment status.", "exito"),
  } },
  reserva: { nombre: "Reservation & booking management", destino: "#w7-reserva", referencia: "DEMO-BOOK-001", estados: {
    inicial: estado("Plan your visit", "Choose guests and a restaurant local date.", "Explore example times."),
    buscando: estado("Looking for times · demo", "No live restaurant availability is queried.", "Wait for the example search to finish."),
    disponible: estado("Example times available", "The displayed hours are synthetic options, not available tables.", "Choose a time for this preview."),
    sinHoras: estado("No example availability", "No times are shown for this demonstration state.", "Choose another date and search again.", "aviso"),
    seleccionado: estado("Example time selected", "Your preferred date and time have not been held.", "Review guests and fictional contact details."),
    perdido: estado("Example time no longer available", "Availability can change before confirmation. Your other entries are preserved.", "Search again and select another time.", "aviso"),
    error: estado("Reservation request failed · demo", "No reservation has been created.", "Review the request and retry the local example.", "error"),
    pendiente: estado("Reservation request pending · demo", "A request is not a confirmed table.", "Check the request result before sending it again."),
    confirmada: estado("Reservation confirmed · simulation only", "Fictional visit: May 18, 2028 · 6:00 PM PDT · 2 guests. No table is booked.", "Review the fictional booking management example.", "exito"),
    modificada: estado("Reservation modified · demo", "A conceptual confirmed-change view. No restaurant record changed.", "Review the new confirmed date and guest count.", "exito"),
    cancelada: estado("Reservation cancelled · demo", "The example cancellation is complete. No real booking changed.", "Review any independently confirmed payment outcome.", "aviso"),
    politica: estado("Policy review required · demo", "Change or cancellation eligibility cannot be established until applicable terms are confirmed.", "Discuss the request with the restaurant; no policy is invented here.", "aviso"),
    noShow: estado("Recorded as no-show · future example", "Informational status only. No penalty or policy is implied.", "Contact the restaurant through the verified booking channel if this is incorrect."),
  } },
  regalo: { nombre: "Gift Card transaction", destino: "#w7-regalo", referencia: "DEMO-GIFT-001", estados: {
    seleccion: estado("Gift selected · demo", "Your example amount and personal note are ready for review.", "Review presentation, delivery and commercial terms when confirmed."),
    pago: estado("Gift payment pending · demo", "No payment result or card issuance is confirmed.", "Check the payment result before repeating the transaction."),
    emision: estado("Gift issuance pending · demo", "Payment and issuance are separate states. No redeemable card exists here.", "Check issuance only after an authoritative payment result."),
    emitida: estado("Gift issued · simulation only", "This is an issuance confirmation layout. It contains no code, balance or redeemable value.", "A real service will provide its confirmed delivery instructions.", "exito"),
    error: estado("Gift issuance failed · demo", "A payment result must be checked separately. Do not repurchase to recover an issuance problem.", "Ask the future service to reconcile payment and issuance.", "error"),
  } },
  club: { nombre: "Wine Club subscription", destino: "#w7-club", referencia: "DEMO-CLUB-001", estados: {
    condiciones: estado("Membership terms unconfirmed", "Current price, included benefits and billing cadence are not yet defined.", "Review the confirmed recurring agreement before accepting enrollment."),
    pago: estado("Membership payment pending · demo", "A selected plan is not an active membership.", "Check payment and activation separately."),
    activacion: estado("Membership active · simulation only", "A conceptual activation view; no membership or recurring agreement exists.", "Review the future authoritative membership record.", "exito"),
    renovacion: estado("Next renewal unconfirmed · demo", "No renewal date or billing cadence has been scheduled.", "The provider and server must supply the confirmed renewal details."),
    fallo: estado("Membership payment failed · demo", "A recurring-payment failure example, without a live subscription.", "Use the future provider-hosted payment management flow.", "error"),
    actualizacion: estado("Membership update pending · demo", "The requested change has not taken effect.", "Wait for the provider result before repeating the update."),
    cancelacion: estado("Cancellation scheduled · demo", "The example subscription is scheduled to end; no effective date or policy is invented.", "Review the effective end date supplied by the future service.", "aviso"),
    finalizada: estado("Membership ended · demo", "A conceptual ended state. No real benefits or recurring charges changed.", "Review the final membership record."),
  } },
  evento: { nombre: "Public event registration", destino: "#w7-evento", referencia: "DEMO-EVENT-001", estados: {
    seleccion: estado("Event selected · demo", "A journey through Spanish wine · May 18, 2028. Entirely hypothetical.", "Review attendees, price and event conditions."),
    pendiente: estado("Event registration pending · demo", "No place is reserved until the server confirms capacity and registration.", "Check the registration result before submitting again."),
    confirmado: estado("Event registration confirmed · simulation only", "This example does not issue a ticket or hold a seat.", "Review the fictional event and attendee summary.", "exito"),
    agotado: estado("Event sold out · demo", "No example places are available. No waiting list is offered.", "Return to the event listing.", "aviso"),
    cancelado: estado("Event cancelled · demo", "The fictional event is cancelled. No refund commitment is implied.", "Check any independent payment outcome and confirmed event terms.", "aviso"),
    reprogramado: estado("Event rescheduled · demo", "A new date must be provided and confirmed by the organizer.", "Review the revised event details before making plans."),
    error: estado("Registration failed · demo", "Your example attendee details are preserved.", "Review capacity and retry the preview.", "error"),
  } },
  privada: { nombre: "Private experience inquiry", destino: "#private-experiences", referencia: "DEMO-INQUIRY-001", estados: {
    recibida: estado("Inquiry received · demo", "The conversation has begun; no venue, date or table is reserved.", "Wait for the team to assess the request."),
    revision: estado("Inquiry under review · demo", "The team would evaluate the occasion and possibilities.", "No action is needed until more information or a proposal is requested."),
    informacion: estado("More information needed · demo", "The example inquiry needs clarification about the occasion.", "Return to the inquiry details; share only the requested information."),
    propuesta: estado("Proposal available · demo", "A proposal is not a confirmed reservation or accepted quote.", "Review scope, availability and conditions with the team."),
    confirmada: estado("Private experience confirmed · simulation only", "This represents a later, separate confirmation after agreement. No real event is arranged.", "Review the agreed details supplied by the future service.", "exito"),
    noDisponible: estado("Private experience unavailable · demo", "The fictional inquiry cannot be accommodated as requested.", "Discuss alternative arrangements with the team.", "aviso"),
    cerrada: estado("Inquiry closed · demo", "This fictional conversation is closed without an implied reservation.", "Start a separate inquiry for a different occasion."),
  } },
};
