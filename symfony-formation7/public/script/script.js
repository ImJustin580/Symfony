document.querySelectorAll('.employe-row').forEach(row => {
    row.addEventListener('click', function() {
        const formations = JSON.parse(this.getAttribute('data-formations'));
        const formationList = document.getElementById('formationList');
        formationList.innerHTML = ''; // Réinitialiser la liste

        formations.forEach(formation => {
            const li = document.createElement('li');
            li.textContent = formation;
            formationList.appendChild(li);
        });

        // Afficher la pop-up
        const modal = new bootstrap.Modal(document.getElementById('formationModal'));
        modal.show();
    });
});