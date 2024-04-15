<div class="card mb-4">
    <div>
        <a class="btn btn-primary" href="index.php?page=Contribuables&action=add">Ajouter un contribuale</a>
    </div>
    <div class="card-header">
        <svg class="svg-inline--fa fa-table me-1" aria-hidden="true" focusable="false" data-prefix="fas"
            data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor"
                d="M64 256V160H224v96H64zm0 64H224v96H64V320zm224 96V320H448v96H288zM448 256H288V160H448v96zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z">
            </path>
        </svg><!-- <i class="fas fa-table me-1"></i> Font Awesome fontawesome.com -->
        List des contribuables
    </div>


    <div class="card-body">
        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
            <div class="datatable-top">
                <div class="datatable-dropdown">
                    <label>
                        <select class="datatable-selector">
                            <option value="5">5</option>
                            <option value="10" selected="">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select> entries per page
                    </label>
                </div>
                <div class="datatable-search">
                    <input class="datatable-input" placeholder="Search..." type="search" title="Search within table"
                        aria-controls="datatablesSimple">
                </div>
            </div>
            <div class="datatable-container">
                <table id="datatablesSimple" class="datatable-table">
                    <thead>
                        <tr>
                            <th data-sortable="true" style="width: 19.25936599423631%;"><a href="#"
                                    class="datatable-sorter">Identifiant</a></th>
                            <th data-sortable="true" style="width: 8.30835734870317%;"><a href="#"
                                    class="datatable-sorter">CIN</a></th>
                            <th data-sortable="true" style="width: 15.8895292987512%;"><a href="#"
                                    class="datatable-sorter">Nom & Prenom</a></th>
                            <th data-sortable="true" style="width: 14.741594620557157%;"><a href="#"
                                    class="datatable-sorter">Address</a></th>
                            <th data-sortable="true" style="width: 14.505283381364073%;"><a href="#"
                                    class="datatable-sorter">Ville</a></th>
                            <th data-sortable="true" style="width: 12.295869356388089%;"><a href="#"
                                    class="datatable-sorter">Action</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-index="0">
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                        </tr>
                        <tr data-index="1">
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011/07/25</td>
                            <td>$170,750</td>
                        </tr>
                        <tr data-index="2">
                            <td>Ashton Cox</td>
                            <td>Junior Technical Author</td>
                            <td>San Francisco</td>
                            <td>66</td>
                            <td>2009/01/12</td>
                            <td>$86,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="datatable-bottom">
                <div class="datatable-info">Showing 1 to 10 of 57 entries</div>
                <nav class="datatable-pagination">
                    <ul class="datatable-pagination-list">
                        <li class="datatable-pagination-list-item datatable-hidden datatable-disabled"><a data-page="1"
                                class="datatable-pagination-list-item-link">‹</a></li>
                        <li class="datatable-pagination-list-item datatable-active"><a data-page="1"
                                class="datatable-pagination-list-item-link">1</a></li>
                        <li class="datatable-pagination-list-item"><a data-page="2"
                                class="datatable-pagination-list-item-link">2</a></li>
                        <li class="datatable-pagination-list-item"><a data-page="3"
                                class="datatable-pagination-list-item-link">3</a></li>
                        <li class="datatable-pagination-list-item"><a data-page="4"
                                class="datatable-pagination-list-item-link">4</a></li>
                        <li class="datatable-pagination-list-item"><a data-page="5"
                                class="datatable-pagination-list-item-link">5</a></li>
                        <li class="datatable-pagination-list-item"><a data-page="6"
                                class="datatable-pagination-list-item-link">6</a></li>
                        <li class="datatable-pagination-list-item"><a data-page="2"
                                class="datatable-pagination-list-item-link">›</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>