<div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header">
        <h3 class="font-weight-light my-4">Ajouter un contribuables</h3>
    </div>
    <div class="card-body">
        <form id="contribualeForm" method="post">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="inputCIN" name="CIN" type="text" placeholder="cd00001">
                        <label for="inputCIN">CIN</label>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="inputFullName" name="fullName" type="text" placeholder="Nom prenom">
                        <label for="inputFullName">Nom prenom</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="">
                    <div class="form-floating">
                        <input class="form-control" id="inputIdentifiant" name="identifiant" type="text" placeholder="identifiant">
                        <label for="inputIdentifiant">Identifiant</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                        <input class="form-control" id="inputVille" name="Ville" type="text" placeholder="Tetouan">
                        <label for="inputVille">Ville</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="inputAddress" name="address" type="text" placeholder="Address">
                        <label for="inputAddress">Address</label>
                    </div>
                </div>
            </div>
            <div class="mt-4" style="width: 20%;">
                <div class="d-grid"><button type="button" id="addContribualeBtn" class="btn btn-primary btn-block">Ajouter</button></div>
            </div>
        </form>
    </div>
</div>

<div id="message"></div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('contribualeForm');
        const message = document.getElementById('message');

        document.getElementById('addContribualeBtn').addEventListener('click', async (e) => {
            e.preventDefault();

            const formData = {
                action: 'AddContribuale',
                CIN: document.getElementById('inputCIN').value,
                identifiant: document.getElementById('inputIdentifiant').value,
                fullName: document.getElementById('inputFullName').value,
                Ville: document.getElementById('inputVille').value,
                address: document.getElementById('inputAddress').value
            };

            try {
                const response = await fetch('API.php', {
                    method: 'POST',
                    body: JSON.stringify(formData),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    message.innerHTML = '<div class="alert alert-success">Contribuale Ajouté</div>';
                    form.reset();
                } else {
                    message.innerHTML = '<div class="alert alert-danger">Erreur: ' + data.message + '</div>';
                }
            } catch (error) {
                console.error('Error:', error);
                message.innerHTML = '<div class="alert alert-danger">Erreur lors de la connexion au serveur</div>';
            }
        });
    });
</script>
