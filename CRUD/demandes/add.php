<div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header">
        <h3 class="font-weight-light my-4">Etablir une demande</h3>
    </div>
    <div class="card-body">
        <form id="demandeForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="cin" type="text" placeholder="CIN">
                        <label for="Destination">CIN</label>
                        <a class="btn" id="refreshButton" style="color: #0d6efd ; "> <i class="fa fa-refresh"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="mt-2 col-md-6">
                    <table class="table table-bordered">
                        <tbody id="contribualeInfo">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-control" name="destination" id="destination">

                        </select>
                        <label for="Destination">Destination</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">

                        <select class="form-control" name="attestation" id="attestation">

                        </select>

                        <label for="attestation">Attestation</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">

                        <select class="form-control" name="TypeCourier" id="TypeCourier">

                        </select>

                        <label for="TypeCourier">Type courier</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <select class="form-control" name="impotConcerne" id="impotConcerne" multiple>
                        <option value="IR">IR</option>
                        <option value="IS">IS</option>
                        <option value="TVA">TVA</option>
                        <option value="TSC/TH">TSC/TH</option>
                        <option value="TVALSM">TVALSM</option>
                        <option value="PSM">PSM</option>
                        <option value="TSAVA">TSAVA</option>
                        <option value="IRPI">IRPI</option>
                        <option value="INS prix">INS prix</option>
                        <option value="OR">OR</option>
                        <option value="IR RESTITUTION">IR RESTITUTION</option>
                        <option value="REV.ENREG">REV.ENREG</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" id="anneeConcerne" type="number" placeholder="Annes">
                        <label for="inputLastName">Annes</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">

                <div class="col-md-6">
                    <label>Objet</label>

                    <div class="form-floating">

                        <textarea rows="5" cols="60" id="objet"></textarea>
                        <label for="objet"></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>remarque</label>

                    <div class="form-floating">
                        <input type="text" class="form-control" id="remarque" placeholder="remarque">
                        <label for="remarque"></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label>Response au</label>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="reponseAu" placeholder="reponseAu">
                        <label for="reponseAu"></label>
                    </div>
                </div>
            </div>

            <div class="mt-4" style="width: 20%;">
                <button id="addDemande" class="btn btn-primary btn-block">Ajouter</button>
            </div>
        </form>
    </div>

</div>

<!-- Add this script to your HTML file -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to handle refresh button click
        document.getElementById('refreshButton').addEventListener('click', function (e) {
            e.preventDefault();

            // Get the CIN value
            var cin = document.getElementById('cin').value;

            // Fetch request to get contribuale information
            fetch('API.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'GetContribualeInfo',
                    CIN: cin
                })
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Failed to fetch contribuale information.');
                    }
                    return response.json();
                })
                .then(function (data) {
                    // Clear previous table content
                    var tableBody = document.getElementById('contribualeInfo');
                    tableBody.innerHTML = '';

                    // Populate the table with contribuale information

                    var row = document.createElement('tr');
                    row.innerHTML = '<td>' + data.CIN + '</td>' +
                        '<td>' + data.fullName + '</td>' +
                        '<td>' + data.address + '</td>' +
                        '<td>' + data.Ville + '</td>';
                    tableBody.appendChild(row);

                })
                .catch(function (error) {
                    console.error(error);
                });
        });

        // Function to handle form submission when #addDemande is clicked
        document.getElementById('addDemande').addEventListener('click', function (e) {
            e.preventDefault();

            // Get input values
            const cin = document.getElementById('cin').value;
            const destination = document.getElementById('destination').value;
            const attestation = document.getElementById('attestation').value;
            const impotConcerne = Array.from(document.getElementById('impotConcerne').selectedOptions).map(option => option.value).toString();
            const objet = document.getElementById('objet').value;
            const remarque = document.getElementById('remarque').value;
            const TypeCourier =document.getElementById('TypeCourier').value;
            const anneeConcerne =document.getElementById('anneeConcerne').value;
            const reponseAu =document.getElementById('reponseAu').value;

            // Prepare data object
            const data = {
                action: 'AddDemande',
                cin: cin,
                destination: destination,
                TypeCourier: TypeCourier,
                attestation: attestation,
                anneeConcerne: anneeConcerne,
                impotConcerne: impotConcerne,
                objet: objet,
                remarque: remarque,
                reponseAu:reponseAu
            };

            // Send POST request to API.php
            fetch('API.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    window.location.replace("index.php?page=recu&demande_id="+data);

                })
                .catch(error => console.error('Error adding demande:', error));
        });
    });


    window.onload = function () {
        // Prepare POST data
        let postData = {
            action: 'GetAttestationType'
        };

        // Configure the fetch request
        let requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(postData)
        };

        // Make a request to the API.php to get attestation types
        fetch('API.php', requestOptions)
            .then(response => response.json())
            .then(data => {
                // Assuming data is an array of attestation types
                const attestationTypes = data;

                // Get the select element
                const selectElement = document.getElementById('attestation');

                // Clear any existing options
                selectElement.innerHTML = '';

                // Iterate over the attestation types and create options
                attestationTypes.forEach(attestation => {
                    const option = document.createElement('option');
                    option.value = attestation.name; // Assuming each attestation object has an id property
                    option.text = attestation.name; // Assuming each attestation object has a name property
                    selectElement.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching attestation types:', error));

        postData = {
            action: 'GetDestination'
        };

        // Configure the fetch request
        requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(postData)
        };

        fetch('API.php', requestOptions)
            .then(response => response.json())
            .then(data => {
                // Assuming data is an array of destination types
                const destinationTypes = data;

                // Get the select element
                const selectElement = document.getElementById('destination');

                // Clear any existing options
                selectElement.innerHTML = '';

                // Iterate over the destination types and create options
                destinationTypes.forEach(destination => {
                    const option = document.createElement('option');
                    option.value = destination.name; // Assuming each destination object has an id property
                    option.text = destination.name; // Assuming each destination object has a name property
                    selectElement.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching destination types:', error));
    };



    postData = {
        action: 'GetTypeCourier'
    };

    // Configure the fetch request
    requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(postData)
    };

    fetch('API.php', requestOptions)
        .then(response => response.json())
        .then(data => {
            // Assuming data is an array of destination types
            const TypeCourierTypes = data;

            // Get the select element
            const selectElement = document.getElementById('TypeCourier');

            // Clear any existing options
            selectElement.innerHTML = '';

            // Iterate over the destination types and create options
            TypeCourierTypes.forEach(TypeCourier => {
                const option = document.createElement('option');
                option.value = TypeCourier.name; // Assuming each destination object has an id property
                option.text = TypeCourier.name; // Assuming each destination object has a name property
                selectElement.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching destination types:', error));
    



</script>