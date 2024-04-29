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
    case 'GetTypeCourier':
        handleGetTypeCourier($data, $conn);
        break;
    case 'AddDemande':
        handleAddCourierAndDemande($data, $conn);
        break;
    case 'GetReceipt':
        handleGetReceiptData($data, $conn);
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
    $sql = "SELECT id, name FROM typeCourier";
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
    $sql = "SELECT id, name FROM destination";
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
    $sql = "SELECT id, name FROM typeAttestation";
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
