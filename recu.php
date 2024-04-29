<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-section, #print-section * {
                visibility: visible;
            }
            #print-section {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card" id="print-section">
                    <div class="card-header bg-primary text-white">
                        Reçu
                    </div>
                    <div class="card-body" id="receipt-body">
                        <!-- Receipt data will be dynamically populated here -->
                    </div>
                </div>
                <button class="btn btn-primary mt-3" onclick="window.print()">Imprimer le reçu</button>
            </div>
        </div>
    </div>

    <!-- Add this script to your HTML file -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to get URL parameter by name
            function getUrlParameter(name) {
                name = name.replace(/[\[\]]/g, '\\$&');
                var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                    results = regex.exec(window.location.href);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }

            // Get demande ID from URL
            var demandeId = getUrlParameter('demande_id');

            // Fetch data from API.php
            fetch('API.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'GetReceipt',
                    demande_id: demandeId // Include demande ID in the request body
                })
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Failed to fetch receipt data.');
                    }
                    return response.json();
                })
                .then(function (data) {
                    // Populate receipt with fetched data
                    var receiptBody = document.getElementById('receipt-body');
                    var html = '';
                    html += '<ul class="list-group list-group-flush">';
                    html += '<li class="list-group-item"><strong>CIN:</strong> ' + data.CIN + '</li>';
                    html += '<li class="list-group-item"><strong>Nom Prénom:</strong> ' + data.fullName + '</li>';
                    html += '<li class="list-group-item"><strong>Adresse:</strong> ' + data.address + '</li>';
                    html += '<li class="list-group-item"><strong>Ville:</strong> ' + data.Ville + '</li>';
                    html += '<li class="list-group-item"><strong>Identifiant:</strong> ' + data.identifiant + '</li>';
                    html += '<li class="list-group-item"><strong>Destination:</strong> ' + data.destination + '</li>';
                    html += '<li class="list-group-item"><strong>Type de Courrier:</strong> ' + data.typeCourier + '</li>';
                    html += '<li class="list-group-item"><strong>Attestation:</strong> ' + data.typeAttestation + '</li>';
                    html += '<li class="list-group-item"><strong>Année Concernée:</strong> ' + data.anneeConcerne + '</li>';
                    html += '<li class="list-group-item"><strong>Impôt Concerné:</strong> ' + data.impotConcerne + '</li>';
                    html += '<li class="list-group-item"><strong>Objet:</strong> ' + data.objet + '</li>';
                                        html += '<li class="list-group-item"><strong>Objet2:</strong> ' + data.objet2 + '</li>';
                    html += '<li class="list-group-item"><strong>Remarque:</strong> ' + data.remarque + '</li>';
                                        html += '<li class="list-group-item"><strong>Remarque2:</strong> ' + data.remarque2 + '</li>';
                    html += '<li class="list-group-item"><strong>Réponse à:</strong> ' + data.reponseAu + '</li>';
                    html += '</ul>';
                    receiptBody.innerHTML = html;
                })
                .catch(function (error) {
                    console.error(error);
                });
        });
    </script>
</body>
</html>
