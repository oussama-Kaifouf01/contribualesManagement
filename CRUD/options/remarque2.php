    <div class="card mb-4">

        <div class="card-header">
            <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas" 
                data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                <path fill="currentColor" 
                    d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z">
                </path>
            </svg><!-- <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com -->
            List des remarque2
        </div>


        <div class="card-body">
            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                <div class="datatable-top">
                    <div id="formToAddTypeRemarque2" class="form-group">
                        <div>
                            <label for="typeName" class="form-label">Type De remarque2:</label><br>
                            <input type="text" id="typeName" name="typeName" class="form-control form-control-sm"><br>
                            <button id="submitAddTypeRemarque2" class="btn btn-primary btn-sm">Ajouter</button>
                        </div>
                    </div>
                    <script>
                        const submitButton = document.querySelector('#submitAddTypeRemarque2');
                        submitButton.addEventListener('click', async () => {
                            const typeName = document.querySelector('#typeName').value;
                            const response = await fetch('API.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ action: 'AddRemarque2', typeName })
                            }).then(() => {
                                document.querySelector('#typeRemarque2sBody').innerHTML = ""

                                populateTypeRemarque2s()
                            });
                        });

                    </script>

                </div>
            </div>
            <div class="datatable-container">
                <table id="contribualesTable" class="datatable-table table">
                    <thead>
                        <tr>
                            <th data-sortable="true" style="width: 19.25936599423631%;"><a href="#" 
                                    class="datatable-sorter">Type De remarque2</a></th>
                            <th data-sortable="true" style="width: 19.25936599423631%;"><a href="#"
                                    class="datatable-sorter">Action</a></th>
                        </tr>
                    </thead>
                    <tbody id="typeRemarque2sBody" class="table-group-divider">
                        <!-- Contribuales data will be populated here -->
                    </tbody>
                    <script>
                        const typeRemarque2sBody = document.querySelector('#typeRemarque2sBody');

                        const populateTypeRemarque2s = async () => {
                            const response = await fetch('API.php?action=GetRemarque2');
                            const typeRemarque2s = await response.json();

                            typeRemarque2s.forEach(async (typeRemarque2) => {
                                const tr = document.createElement('tr');

                                const td1 = document.createElement('td');
                                td1.textContent = typeRemarque2.name;

                                const td2 = document.createElement('td');
                                const deleteButton = document.createElement('button');
                                deleteButton.classList.add('btn', 'btn-danger', 'btn-sm');
                                deleteButton.textContent = 'Supprimer';
                                deleteButton.addEventListener('click', async () => {
                                    const response = await fetch('API.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            action: 'DeleteRemarque2',
                                            typeName: typeRemarque2.name
                                        })
                                    });
                                    document.querySelector('#typeRemarque2sBody').innerHTML = ""
                                    populateTypeRemarque2s();
                                });
                                td2.appendChild(deleteButton);

                                tr.appendChild(td1);
                                tr.appendChild(td2);

                                typeRemarque2sBody.appendChild(tr);
                            });
                        };
                        populateTypeRemarque2s();



                    </script>
                </table>
            </div>

        </div>
    </div>
