$(document).ready(function() {
  // Button handlers using jQuery
  $("#login").click(function() {
      window.location.href = "login.html";
  });

  $("#offre").click(function() {
      window.location.href = "signup.html";
  });

  // Vehicle list handling
  const handleVehicleList = (listId, url) => {
      if (!$(listId).length) return;

      $.getJSON(url)
          .done(data => {
              const renderItem = vehicle => `
                  <div class="car-item">
                      <img src="uploads/${vehicle.image}" alt="${vehicle.marque} ${vehicle.modele}">
                      <div class="car-details">
                          <h3>${vehicle.marque} ${vehicle.modele}</h3>
                          <p>Prix par jour: ${vehicle.prix_jour} TND</p>          
                          <p>Propriétaire: ${vehicle.nom}</p>
                          <p>Téléphone: ${vehicle.telephone}</p>
                      </div>
                  </div>
              `;

              $(listId).html(data.map(renderItem).join(''));

              $(".search-button").click(function() {
                  const marque = $('input[name="marque"]').val().toLowerCase();
                  const modele = $('input[name="modele"]').val().toLowerCase();
                  const prixMax = parseFloat($('input[name="prix_max"]').val());

                  const filtered = data.filter(vehicle => {
                      const matchesMarque = !marque || vehicle.marque.toLowerCase().includes(marque);
                      const matchesModele = !modele || vehicle.modele.toLowerCase().includes(modele);
                      const matchesPrix = isNaN(prixMax) || vehicle.prix_jour <= prixMax;
                      return matchesMarque && matchesModele && matchesPrix;
                  });

                  $(listId).html(filtered.map(renderItem).join(''));
              });
          })
          .fail(error => console.error('Erreur:', error));
  };

  // Initialize vehicle lists
  handleVehicleList('#vehicule-list', 'php/get_vehicule.php');
  handleVehicleList('#vehicule-list-personel', 'php/mes_voitures.php');
});