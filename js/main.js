document.addEventListener('DOMContentLoaded', function() {
    // Only set the login button functionality if the element exists
    const loginButton = document.getElementById("login");
    if (loginButton) {
      loginButton.onclick = function() {
        window.location.href = "login.html";
      };
    }
  
    // Only set the signup button functionality if the element exists
    const offreButton = document.getElementById("offre");
    if (offreButton) {
      offreButton.onclick = function() {
        window.location.href = "signup.html";
      };
    }
  
    // Only fetch and display vehicles if we are on the right page (louer.html)
    if (document.getElementById('vehicule-list')) {
      fetch('php/get_vehicule.php')
        .then(response => response.json())
        .then(data => {
          const vehicleList = document.getElementById('vehicule-list');
          if (vehicleList) {
            data.forEach(vehicle => {
              console.log(data);
              const html = `
                <div class="vehicle-card">
                  <img src="uploads/${vehicle.image}" alt="${vehicle.marque} ${vehicle.modele}">
                  <h3>${vehicle.marque} ${vehicle.modele}</h3>
                  <p>Prix par jour: ${vehicle.prix_jour} TND</p>
                </div>
              `;
              vehicleList.innerHTML += html;
            });
          }
        })
        .catch(error => console.error('Erreur:', error));
    }
  });
  