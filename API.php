<?php
header('Content-Type: application/json');
session_start();

include 'config/db.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get POST data
$data = json_decode(file_get_contents("php://input"));

$action = isset($data->action) ? $data->action : $_GET["action"];

switch ($action) {
    case 'AddContribuale':
        handleAddContribuale($data, $conn);
        break;
    case 'DeleteContribuale':
        handleDeleteContribuale($data, $conn);
        break;
    case 'GetContribuales':
        handleGetContribuale($conn);
        break;
    case 'GetContribualeInfo':
        handleGetContribualeInfo($data, $conn);
        break;
    case 'GetAttestationType':
        handleGetAttestationType($data, $conn);
        break;
    case 'GetDestination':
        handleGetDestination($data, $conn);
        break;
    case 'deleteTypeDestination':
        handleDeleteDestination($data, $conn);
        break;
    case 'GetTypeCourier':
        handleGetTypeCourier($data, $conn);
        break;
    case 'AddDemande':
        handleAddCourierAndDemande($data, $conn);
        break;
    case 'GetReceipt':
        handleGetReceiptData($data, $conn);
        break;
    case 'GetRemarque2':
        handleGetRemarque2($conn);
        break;
    case 'AddRemarque2':
        handleAddRemarque2($data, $conn);
        break;
    case 'DeleteRemarque2':
        handleDeleteRemarque2($data, $conn);
        break;
    case 'GetObjet2':
        handleGetObjet2($conn);
        break;
    case 'AddObjet2':
        handleAddObjet2($data, $conn);
        break;
    case 'DeleteObjet2':
        handleDeleteObjet2($data, $conn);
        break;
    case 'addTypeCourier':
        handleAddTypeCourier($data, $conn);
        break;
    case 'deleteTypeCourier':
        handleDeleteTypeCourier($data, $conn);
        break;
    case 'addTypeAttestation':
        handleAddTypeAttestation($data, $conn);
        break;
    case 'deleteTypeAttestation':
        handleDeleteTypeAttestation($data, $conn);
        break;
    case 'addTypeDestination':
        handleAddTypeDestination($data, $conn);
        break;


    case 'GetReceiptData':

        // Get filter parameters
        $startDate = isset($data->startDate) ? $data->startDate : null;
        $endDate = isset($data->endDate) ? $data->endDate : null;
        $typeCourier = isset($data->typeCourier) ? $data->typeCourier : null;
        $typeDestination = isset($data->typeDestination) ? $data->typeDestination : null;
        $typeAttestation = isset($data->typeAttestation) ? $data->typeAttestation : null;
        $CIN = isset($data->CIN) ? $data->CIN : null;

        // Generate filter query
        $sql = generateFilterQuery($startDate, $endDate, $typeCourier, $typeDestination, $typeAttestation, $CIN);

        // Execute the query
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Fetch data
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            // Return data as JSON
            echo json_encode($rows);
        } else {
            // No data found based on filters
            echo json_encode(['success' => false, 'message' => 'No data found based on provided filters']);
        }
        break;

}



function handleDeleteContribuale($data, $conn)
{
    // Get contribuale id from request data
    $contribualeId = $data->contribualeId;

    // Delete contribuale from database
    $sql = "DELETE FROM contribuale WHERE CIN = '$contribualeId'";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Contribuale deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting contribuale'
        ];
    }

    echo json_encode($response);

}





function handleDeleteRemarque2($data, $conn)
{
    // Get remarque2 id from request data
    $remarque2name = $data->typeName;
    // Delete remarque2 from database
    $sql = "DELETE FROM remarque2 WHERE name = '$remarque2name'";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Remarque2 deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting remarque2'
        ];
    }
    echo json_encode($response);

}


function handleAddRemarque2($data, $conn)
{

    // Get remarque2 text from request data
    $remarque2Text = $data->typeName;

    // Insert new remarque2 into database
    $sql = "INSERT INTO remarque2 (name) VALUES ('$remarque2Text')";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Remarque2 added successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error adding remarque2'
        ];
    }

    echo json_encode($response);

}




function handleAddObjet2($data, $conn)
{

    // Get objet2 name from request data
    $objet2Name = $data->typeName;

    // Insert new objet2 into database
    $sql = "INSERT INTO objet2 (name) VALUES ('$objet2Name')";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Objet2 added successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error adding objet2'
        ];
    }

    echo json_encode($response);

}




function handleDeleteObjet2($data, $conn)
{
    // Get type name from request data
    $typeName = $data->typeName;

    // Delete type from database
    $sql = "DELETE FROM objet2 WHERE name = '$typeName'";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting type'
        ];
    }

    echo json_encode($response);


}
function handleDeleteDestination($data, $conn)
{
    // Get type ID from request data
    $typeDestinationName = $data->typeDestinationName;

    // Delete type from database
    $sql = "DELETE FROM destination WHERE name = '$typeDestinationName'";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting type'
        ];
    }

    echo json_encode($response);
}




function handleDeleteTypeAttestation($data, $conn)
{
    // Get type ID from request data
    $typeAttestationName = $data->typeAttestationName;

    // Delete type from database
    $sql = "DELETE FROM typeAttestation WHERE name = '$typeAttestationName'";
    echo $sql;
    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting type'
        ];
    }

    echo json_encode($response);

}
function handleDeleteTypeCourier($data, $conn)
{
    // Get type ID from request data
    $typeCourierName = $data->typeCourierName;

    // Delete type from database
    $sql = "DELETE FROM typeCourier WHERE name = '$typeCourierName'";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type deleted successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error deleting type'
        ];
    }

    echo json_encode($response);

}


function handleAddTypeDestination($data, $conn)
{

    // Get type name from request data
    $typeName = $data->typeName;

    // Insert new type into database
    $sql = "INSERT INTO destination (name) VALUES ('$typeName')";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type added successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error adding type'
        ];
    }

    echo json_encode($response);

}

function handleAddTypeAttestation($data, $conn)
{

    // Get type name from request data
    $typeName = $data->typeName;

    // Insert new type into database
    $sql = "INSERT INTO typeAttestation (name) VALUES ('$typeName')";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type added successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error adding type'
        ];
    }

    echo json_encode($response);

}

function handleAddTypeCourier($data, $conn)
{

    // Get type name from request data
    $typeName = $data->typeName;

    // Insert new type into database
    $sql = "INSERT INTO typeCourier (name) VALUES ('$typeName')";

    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Type added successfully'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error adding type'
        ];
    }

    echo json_encode($response);

}

function handleGetObjet2($conn)
{
    $sql = "SELECT id, name FROM objet2 ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $objet2Data = [];
        while ($row = $result->fetch_assoc()) {
            $objet2Data[] = $row;
        }
        echo json_encode($objet2Data);
    } else {
        echo json_encode(['success' => false, 'message' => 'No objet2 data found']);
    }
}

function handleGetRemarque2($conn)
{
    $sql = "SELECT id, name FROM remarque2 ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $remarque2Data = [];
        while ($row = $result->fetch_assoc()) {
            $remarque2Data[] = $row;
        }
        echo json_encode($remarque2Data);
    } else {
        echo json_encode(['success' => false, 'message' => 'No remarque2 data found']);
    }
}


function generateFilterQuery($startDate, $endDate, $typeCourier, $typeDestination, $typeAttestation, $CIN)
{
    // Initialize the base query
    $sql = "SELECT d.*, c.*, co.* FROM demande d
            JOIN contribuale c ON d.idContribuale = c.CIN
            JOIN courier co ON d.idCourier = co.id";

    // Add filters based on provided parameters
    $whereClauses = [];
    if ($startDate && $endDate) {
        if ($startDate === $endDate) {
            // Adjust the end date to the end of the day
            $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
        }
        $whereClauses[] = "d.date BETWEEN '$startDate' AND '$endDate'";
    }
    if ($typeCourier) {
        $whereClauses[] = "co.typeCourier = '$typeCourier'";
    }
    if ($typeDestination) {
        $whereClauses[] = "co.destination = '$typeDestination'";
    }
    if ($typeAttestation) {
        $whereClauses[] = "co.typeAttestation = '$typeAttestation'";
    }
    if ($CIN) {
        $whereClauses[] = "c.CIN = '$CIN'";
    }

    // Combine all where clauses
    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    return $sql;
}

function handleGetReceiptData($data, $conn)
{
    // Check if demande ID is provided in the request
    if (isset($data->demande_id)) {
        $demande_id = $data->demande_id;

        // Query to fetch demande information along with contribuale and courier information
        $sql = "SELECT d.*, c.*, co.* FROM demande d
                JOIN contribuale c ON d.idContribuale = c.CIN
                JOIN courier co ON d.idCourier = co.id
                WHERE d.id = $demande_id";

        // Execute the query
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Fetch data
            $row = $result->fetch_assoc();

            // Return data as JSON
            echo json_encode($row);
        } else {
            // No data found with the provided demande ID
            echo json_encode(['success' => false, 'message' => 'No data found for the provided demande ID']);
        }
    } else {
        // No demande ID provided
        echo json_encode(['success' => false, 'message' => 'Demande ID not provided']);
    }
}



function handleAddCourierAndDemande($data, $conn)
{
    // Extract data from the request body
    $cin = $data->cin;
    $destination = $data->destination;
    $attestation = $data->attestation;
    $impotConcerne = $data->impotConcerne; // Convert array to comma-separated string
    $typeCourier = $data->TypeCourier;
    $remarque = $data->remarque;
    $remarque2 = $data->remarque2;
    $anneeConcerne = $data->anneeConcerne;
    $responseAu = $data->responseAu;
    $objet = $data->objet;
    $objet2 = $data->objet2;
    // Add data to the `courier` table
    $sqlCourier = "INSERT INTO courier (destination, typeCourier, typeAttestation, impotConcerne,anneeConcerne, remarque,objet,remarque2,objet2,reponseAu) 
                   VALUES ('$destination', '$typeCourier', '$attestation', '$impotConcerne','$anneeConcerne', '$remarque','$objet','$remarque2','$objet2','$responseAu')";

    if ($conn->query($sqlCourier) === TRUE) {
        // Get the ID of the inserted courier
        $courierId = $conn->insert_id;

        // Add data to the `demande` table
        $sqlDemande = "INSERT INTO demande (idCourier, idContribuale, date) 
                       VALUES ('$courierId', (SELECT CIN FROM contribuale WHERE CIN = '$cin'), NOW())";
        if ($conn->query($sqlDemande) === TRUE) {
            echo $conn->insert_id;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding demande: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding courier: ' . $conn->error]);
    }
}

function handleGetTypeCourier($data, $conn)
{
    $sql = "SELECT name, id FROM typeCourier ORDER BY id DESC";

    $result = $conn->query($sql);


    if ($result && $result->num_rows > 0) {
        $typeCourier = [];
        while ($row = $result->fetch_assoc()) {
            $typeCourier[] = $row;
        }
        echo json_encode($typeCourier);
    } else {
        echo json_encode(['success' => false, 'message' => 'typeCourier']);
    }
}
function handleGetDestination($data, $conn)
{
    $sql = "SELECT id, name FROM destination ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $destination = [];
        while ($row = $result->fetch_assoc()) {
            $destination[] = $row;
        }
        echo json_encode($destination);
    } else {
        echo json_encode(['success' => false, 'message' => 'Destination']);
    }
}

function handleGetContribualeInfo($data, $conn)
{
    // Check if CIN is provided in the request data
    if (!isset($data->CIN)) {
        echo json_encode(['success' => false, 'message' => 'CIN is missing in the request.']);
        return;
    }

    // Sanitize the input to prevent SQL injection
    $CIN = mysqli_real_escape_string($conn, $data->CIN);

    // // Prepare and execute the query to fetch contribuale information
    $sql = "SELECT * FROM contribuale WHERE CIN = '$CIN'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch contribuale information.']);
        return;
    }

    // Fetch the single contribuale from the result set
    $contribuale = $result->fetch_assoc();

    // Close the database connection
    $conn->close();

    // Check if a contribuale was found
    if ($contribuale) {
        // Return the contribuale information as JSON response
        echo json_encode($contribuale);
    } else {
        echo json_encode(['success' => false, 'message' => 'Contribuale not found.']);
    }
}

function handleGetAttestationType($data, $conn)
{
    $sql = "SELECT id, name FROM typeAttestation ORDER BY id DESC ";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $attestationTypes = [];
        while ($row = $result->fetch_assoc()) {
            $attestationTypes[] = $row;
        }
        echo json_encode($attestationTypes);
    } else {
        echo json_encode(['success' => false, 'message' => 'No attestation types found']);
    }
}
function handleGetContribuale($conn)
{
    $sql = "SELECT * FROM `contribuale`";
    $result = $conn->query($sql);

    if ($result) {
        $contribuales = [];
        while ($row = $result->fetch_assoc()) {
            $contribuales[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $contribuales]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching contribuales']);
    }
}

function handleAddContribuale($data, $conn)
{
    $CIN = $data->CIN;
    $identifiant = $data->identifiant;
    $fullName = $data->fullName;
    $address = $data->address;
    $Ville = $data->Ville;

    $sql = "INSERT INTO `contribuale` (`CIN`, `identifiant`, `fullName`, `address`, `Ville`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $CIN, $identifiant, $fullName, $address, $Ville);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Contribuables ajouté avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du contribuable: ' . $stmt->error]);
    }

    $stmt->close();
}
