<?php
require "../../../utils/header.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 10;

// Prepare the SQL statement and get records from about_me table, and only show the one that belongs to the user logged in
$stmt = $pdo->prepare("SELECT * FROM contact_request ORDER BY contact_requestID LIMIT :current_page, :record_per_page");
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contact_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of ..., this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM contact_request')->fetchColumn();

// Check if form was submitted
if (isset($_POST['save_contact'])) {
    // Sanitize POST array
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    // Get checkbox value
    $seen = isset($_POST['seen']) ? 1 : 0;
    // Update contact request
    $stmt = $pdo->prepare('UPDATE contact_request SET seen = ? WHERE contactID = ?');
    $stmt->execute([$seen, $_POST['contactID']]);
    // Set the text of the seen field based on the value of the $seen variable
    if ($seen) {
        $seenText = "seen";
        } else {
        $seenText = "not seen";
        }
            
        echo $seenText;
    header('Location: read.php');
    exit;
}

?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Contact Requests</h2>
    <!-- To hide the "Create About me" link if the user already has an "About me" section, we wrap the link in an if statement and check if the $about_me variable is empty or not.-->
	<table>
        <thead>
            <tr>
                <td>Contact Request ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Message</td>
                <td>Seen</td>
                <td>Seen At</td>
                <td>Created</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contact_requests as $contact): ?>
            <tr>
                <td><?=$contact['contact_requestID']?></td>
                <td><?=$contact['contact_name']?></td>
                <td><?=$contact['contact_email']?></td>
                <td><?=$contact['message']?></td>
                <td>
                <!-- Toggle switch -->
                <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="flexSwitchCheckDefault" onchange="updateContactRequest(<?=$contact['contact_requestID']?>, this.checked)" <?php echo $contact['seen'] == 1 ? 'checked' : ''; ?>>
                <label class="form-check-label" id="flexSwitchLabel" for="flexSwitchCheckDefault"><?php echo $contact['seen'] == 1 ? 'seen' : 'not seen'; ?></label>
                </div>
                </td>
                <td>
                    <?php
                        if ($contact['seen']) {
                            // Display the seen_at value from the database if seen is true
                            echo date('d-m-Y h:i:s a', strtotime($contact['seen_at']));
                        } else {
                            // Display "not seen" if seen is false
                            echo "not seen yet";
                        }
                    ?>
                </td>
                <td><?=date('d-m-Y h:i:s a', strtotime($contact['created']))?></td>
                <td class="actions">
                    <?php if ($_SESSION["userType"] == "Admin"): ?>
                    <a href="delete.php?contact_requestID=<?=$contact['contact_requestID']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<!-- JavaScript function to send an AJAX request to update contact request seen status -->
<script>
function updateContactRequest(contact_requestID, seen) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_seen.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Contact request updated');
        }
        else {
            console.error('An error occurred');
        }
    };
    xhr.send(`contact_requestID=${contact_requestID}&seen=${seen}`);
    location.reload();
}
</script>
<?=template_footer()?>