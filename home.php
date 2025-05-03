<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASK-MVSREC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #343a40 important;
        }
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: white !important;
        }
        .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .content-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
		div.a{
			background-color: #333333;
			color:white;
			
		}
    </style>
</head>
<body style='background-color:#1c1c1c' >
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="home.php">ASK-MVSREC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="announcement.php">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="QA.php">Q&A</a></li>
                   <li class="nav-item"><a class="nav-link" href="post_form.php">New Announcement</a></li>
                    <li class="nav-item"><a class="nav-link" href="question_form.php">Post a Question</a></li>
                </ul>
            </div>
        </div>
    </nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</div> 
<div class="a">
<center>
<?php
session_start();  // Start the session

//$roll_number = $_POST['roll_number'];
//echo "$roll_number";
    echo "WELCOME " . $_SESSION['roll_number'];


?>
<center>
</div>

<div style="color:yellow;background-color:#1c1c1c" class="marquee-container">
    <marquee >
      Assignments | Attendance Issues | Challenges | Canteen | Class bunks | Clubs | Complaints | Confession | CRICKET | Events | Exams | Exam hacks | Festival vibes | Fests | Food | Football | Funny rants | Group fights | Group Studies | Guide | Hackathons | Help | Holidays | Hostel Reviews | Internship | Internal Marks | Lab exams | Lab Records | Late Submissions | Lost & found | Lost ID card | Memes | Movies | Part-Time Jobs | Placements | Politics | Practical Exams | Proxy attendance | Revaluation Drama | Results | Roommate Problems | Rumors | Seniors & Juniors | Sports | Startup Ideas | Student Union | Tech Trends | Timepass Lectures | Viva Drama &nbsp;&nbsp;&nbsp;
    </marquee>
  </div>
  <?php
// Check if this file is being accessed directly
if (basename($_SERVER['PHP_SELF']) == 'home.php') {
?>
<div style="background-color:#1c1c1c; color:#f8f9fa; padding:30px; border-radius:10px;">
  <div class="container">
    <h1 class="text-center" style="color:#ffc107;">📜 Terms & Conditions</h1>
    <p class="text-center"><strong>ASK-MVSREC</strong></p>
    <p><strong>Effective Date:</strong> April 2025 <br>
       <strong>Last Updated:</strong> April 2025</p>

    <h2 style="color:#0dcaf0;">🎯 Purpose of This Platform</h2>
    <p>This web application is designed to:</p>
    <ul>
      <li>Allow students to post formal announcements to the college community.</li>
      <li>Provide a Q&A space for academic and general queries.</li>
      <li>Foster communication, collaboration, and student-led discussions.</li>
      <li>Record and moderate all content to ensure safe usage.</li>
    </ul>

    <h2 style="color:#0dcaf0;">✅ Who Can Use It?</h2>
    <ul>
      <li>Only current students of MVSR Engineering College.</li>
      <li>Authentication via roll number and college email (OTP verification).</li>
      <li>No access for outsiders or faculty members.</li>
    </ul>

    <h2 style="color:#0dcaf0;">⚖️ Terms & Conditions</h2>
    <ul>
      <li>Use respectfully and post relevant content only.</li>
      <li>No impersonation or sharing false/misleading content.</li>
      <li>All activity is recorded with roll number and time.</li>
      <li>Violators may be warned, suspended, or blocked permanently.</li>
    </ul>

    <h2 style="color:#0dcaf0;">🚫 Prohibited Content</h2>
    <ul>
      <li>Hate speech, harassment, or bullying.</li>
      <li>Spam, ads, or self-promotion.</li>
      <li>Offensive language or unrelated media.</li>
      <li>Plagiarism or false academic content.</li>
    </ul>

    <h2 style="color:#0dcaf0;">🔐 Security & Monitoring</h2>
    <p>All activities are logged and monitored. Misuse will result in appropriate action.</p>

    <h2 style="color:#0dcaf0;">💡 Ideas for Using This Platform</h2>
    <ul>
      <li>Announcements for events, lost & found, etc.</li>
      <li>Ask academic, placement, or college life questions.</li>
      <li>Seniors can guide juniors with tips and experiences.</li>
      <li>Freshers can clear doubts and adapt better.</li>
    </ul>

    <h2 style="color:#0dcaf0;">🌟 Platform Features</h2>

    <h5 style="color:#ffc107;">🗣️ Announcements</h5>
    <ul>
      <li>Post formal announcements.</li>
      <li>Others can like/dislike.</li>
    </ul>

    <h5 style="color:#ffc107;">❓ Q&A Forum</h5>
    <ul>
      <li>Ask and answer questions.</li>
      <li>Multiple answers allowed, editable by author only.</li>
    </ul>

    <h5 style="color:#ffc107;">🔐 Authentication</h5>
    <ul>
      <li>Login with roll number.</li>
      <li>OTP verification to college email ID.</li>
    </ul>

    <h5 style="color:#ffc107;">⚙️ Other Features</h5>
    <ul>
      <li>Activity logs maintained.</li>
      <li>Responsive UI for mobile and desktop.</li>
      <li>Proper formatting support for posts and answers.</li>
    </ul>

    <h2 style="color:#0dcaf0;">💬 Feedback & Support</h2>
    <p>This platform is constantly evolving. For any issues or suggestions, please mail the development team at 
      <a href="mailto:adkmvsrec@gmail.com" style="color:#0dcaf0;">adkmvsrec@gmail.com</a>.
    </p>

    <h2 style="color:#0dcaf0;">📢 Final Note</h2>
    <p>This platform is <strong>by MVSR students, for MVSR students</strong>. Use it responsibly, make it meaningful, and help the community grow.</p>
	<p class="text-center" style="color:#adb5bd; font-style:italic;">
  Designed & Developed by <strong>Shaik Abubakr</strong> (2451-22-733-133)
</p>

  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
}
?>
</body>
</html>


