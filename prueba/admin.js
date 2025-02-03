// Seleccionamos todas las listas de noticias para hacerlas draggables
document.querySelectorAll(".news-list").forEach(function (list) {
  new Sortable(list, {
    group: "news-list", // Permite mover entre listas
    animation: 150,
    onEnd: function (evt) {
      let order = [];
      document.querySelectorAll(".news-item").forEach((item, index) => {
        order.push({
          id: item.getAttribute("data-id"),
          is_field: index + 1, // El nuevo is_field se basa en la posición
          category: evt.to.getAttribute("data-category"), // Nueva categoría
        });
      });

      // Enviar el nuevo orden al servidor
      fetch("update_order.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(order),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            alert("Orden actualizado");
          } else {
            alert("Error al actualizar el orden");
          }
        });
    },
  });
});
