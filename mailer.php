<?php
// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Por favor, revisa que has completado todos los datos.";
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "soluciones@innovaciones.co";

    // Set the email subject.
    $subject = "Nuevo contacto: $name";

    // Build the email content.
    $email_content = "Nombre: $name\n";
    $email_content .= "Correo: $email\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Gracias! Su mensaje ha sido enviado satisfactoriamente.";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Lo sentimos, ha ocurrido un error inesperado.";
    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "Hubo un problema con su mensaje, por favor intente nuevamente.";
}
?>
