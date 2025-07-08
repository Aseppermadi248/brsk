<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2>Contact Us</h2>
    <p>Have a question or comment? Fill out the form below to get in touch.</p>

    <form action="process_contact.php" method="POST">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
