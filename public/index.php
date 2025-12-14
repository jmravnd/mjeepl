<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>MjeepL | Jeepney Passenger Predictor</title>
    <link rel="icon" href="jeep.png">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        :root {
            --primary: #1976d2;
            --primary-dark: #0d47a1;
            --bg: #f5f7fa;
            --card: #ffffff;
            --muted: #6b7280;
            --radius: 12px;
        }

.dark {
    --bg: #000000;          /* whole page black */
    --card: #000000;        /* all div panels black */
    --text: #ffffff;        /* main text white */
    --text-muted: #cccccc;  /* lighter gray */
    --input-bg: #ffffff;    /* white inputs */
    --input-text: #000000;  /* black text inside input */
    --radius: 14px;         /* smooth corners */
}

.dark body {
    background: var(--bg);
    color: var(--text);
}


        html, body {
            height: 100%;
            margin: 0;
            font-family: "Roboto", "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            overflow-x: hidden;
        }

        /* Top app bar */
        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--card);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 14px;
            box-shadow: 0 6px 18px rgba(16,24,40,0.08);
            z-index: 1000;
        }
        .logo-area { display: flex; align-items: center; gap: 10px; }
        .logo { height: 36px; width: 36px; object-fit: contain; border-radius: 8px; }
        .app-title { font-weight: 600; color: #111; font-size: 18px; }

        /* Main content */
        .main {
            padding: 80px 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
            height: calc(100vh - 60px - 70px);
            overflow-y: auto;
            box-sizing: border-box;
        }

        /* Cards */
        .card {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 6px 22px rgba(16,24,40,0.06);
        }

        h2 {
            margin: 6px 0 12px;
            font-size: 20px;
            text-align: center;
            color: #111;
        }

        label {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-top: 12px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 9px;
            border: 1px solid #e6eef8;
            margin-top: 6px;
            font-size: 15px;
            background: linear-gradient(180deg, #fff, #fbfdff);
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 6px 18px rgba(25,118,210,0.08);
        }

        /* Fixed Predict Button */
        .action-btn-container {
            position: fixed;
            bottom: 60px;
            left: 0;
            right: 0;
            padding: 0 24px;
            z-index: 1000;
            display: none;
            animation: slideUp .28s ease;
        }

        .action-btn {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
        }

        .action-btn:hover {
            background: var(--primary-dark);
        }

        @keyframes slideUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: var(--card);
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -4px 18px rgba(16,24,40,0.1);
        }

        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 14px;
            color: var(--muted);
            cursor: pointer;
            text-decoration: none;
        }

        .nav-btn.active { color: var(--primary); }
        .nav-btn .material-icons { font-size: 26px; }

        /* History */
        .history-list {
            width: 100%;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .history-item {
            background: var(--card);
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(2,6,23,0.05);
            font-size: 14px;
        }

        .muted { color: var(--muted); font-size: 13px; }

        /* About card */
        .about-card {
            width: 100%;
            max-width: 800px;
            background: var(--card);
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 6px 22px rgba(16,24,40,0.06);
            text-align: center;
        }
        .history-item {
          background: white;
          padding: 16px;
          border-radius: 12px;
          box-shadow: 0 4px 10px rgba(0,0,0,0.08);
          margin-bottom: 12px;
          font-size: 15px;
          border-left: 4px solid var(--primary-dark);
        }

        .weather-badge {
          padding: 4px 8px;
          border-radius: 8px;
          background: #e3f2fd;
          color: var(--primary-dark);
          font-size: 13px;
          font-weight: 600;
        }
        /* Theme Toggle Button */
        .theme-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 6px;
        }

        .theme-btn .material-icons {
            font-size: 28px;
            color: var(--muted);
        }
        /* End Theme Toggle Button */

        /* Card surface in dark mode */
        /* Top bar */
        .dark .topbar {
            background: #000000;  /* pure black */
            color: var(--text);   /* white text/icons */
            border-bottom: 1px solid #ffffff22;
        }

        /* Any divs / containers / sections */
        .dark .card,
        .dark .about-card,
        .dark .history-item,
        .dark .panel,
        .dark section,
        .dark div.content {
            background: var(--card);
            color: var(--text);
        }

        /* Text only */
        .dark h1,
        .dark h2,
        .dark h3,
        .dark p,
        .dark label,
        .dark .title,
        .dark span {
            color: var(--text);
        }

        /* Muted text */
        .dark .muted {
            color: var(--text-muted);
        }

        /* Inputs */
        .dark input,
        .dark select,
        .dark textarea {
            background: var(--input-bg) !important; /* white */
            color: var(--input-text) !important;    /* black */
            border-radius: var(--radius);
            border: 1px solid #ffffff55;
        }

        /* Icons */
        .dark .material-icons {
            color: var(--text);
        }

        /* Buttons (if you want them white text) */
        .dark button {
            color: var(--text);
        }
        /* === ANIMATED SUN/MOON TOGGLE — FIXED === */
        .theme-toggle {
            width: 55px;
            height: 28px;
            background: var(--card);
            border-radius: 30px;
            padding: 3px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            transition: background 0.25s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .toggle-circle {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9d71c; /* bright sun */
            transform: translateX(0);
            transition: all 0.35s cubic-bezier(.4,0,.2,1);
        }

        #themeIcon {
            font-size: 16px;
            color: #000;
        }

        /* DARK */
        .dark .toggle-circle {
            background: #90caf9; /* moon glow */
            transform: translateX(27px);
            box-shadow: 0 0 8px #42a5f5;
        }

        .dark #themeIcon {
            color: #000;
        }

        /* Remove box shadow for form container in Predict tab */
        .dark .predict-form,
        .dark #predict-form,
        .dark .form-container {
            box-shadow: none !important;
        }

        /* Remove box shadow for About container */
        .dark .about-card,
        .dark #about-card,
        .dark .about-container {
            box-shadow: none !important;
        }

        /* Jeepney ML title daw gawing white */
        .dark .app-title,
        .dark .app-name,
        .dark #app-title {
            color: #ffffff !important;
        }

        /* REMOVE ALL SHADOWS IN DARK MODE */
        .dark .card,
        .dark .predict .card,
        .dark #predict .card,
        .dark .predict-form,
        .dark .form-container {
            box-shadow: none !important;
        }

        /* ALSO HISTORY AND ABOUT CARDS */
        .dark .history-item,
        .dark .about-card {
            box-shadow: none !important;
        }
        /* MAKE TOGGLE VISIBLE IN DARK MODE */
        .dark .theme-toggle {
            background: #ffffff0f !important;     /* faint white tint */
            border: 1px solid #ffffff22 !important; /* soft white outline */
            box-shadow: 0 0 6px #ffffff15;        /* slight glow for visibility */
        }
        /* MAKE TOGGLE VISIBLE IN LIGHT MODE */
        .theme-toggle {
            background: #ffffff !important;          /* clean white */
            border: 1px solid #00000022 !important;  /* subtle black outline */
            box-shadow: 0 0 4px #00000015;           /* soft visibility shadow */
        }

    </style>

</head>

<body>
    <!-- TOP APP BAR -->
    <div class="topbar">
        <div class="logo-area">
            <img src="logo.png" alt="Jeepney Logo" class="logo">
            <div class="app-title">MjeepL
                <div class="muted" style="font-size:12px;margin-top:2px">Jeepney Passenger Predictor</div>
            </div>
        </div>
        <div class="theme-toggle" id="themeToggle">
    <div class="toggle-circle" id="toggleCircle">
        <span class="material-icons" id="themeIcon">light_mode</span>
    </div>
</div>


    </div>

    <!-- MAIN -->
    <div class="main" id="main">

        <!-- Predict Panel -->
        <section id="predict" class="panel active">
            <div class="card">
                <h2>Predict Passengers</h2>

                <form id="predictForm" action="predict.php" method="post">

                    <!-- Month -->
                    <div class="select-wrapper">
                        <label>Month</label>
                        <select name="month" required>
                            <option value="" disabled selected>Select a Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>

                    <!-- Day of Week -->
                    <div class="select-wrapper">
                        <label>Day of Week</label>
                        <select name="day" required>
                            <option value="" disabled selected>Select What Day It Is</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                            <option value="7">Sunday</option>
                        </select>
                    </div>

                    <!-- Start Hour -->
                    <div class="select-wrapper">
                        <label>Starting Hour</label>
                        <select name="start" required>
                            <option value="" disabled selected>Select Your Starting Hour</option>
                            <option value="4">04:00 A.M.</option>
                            <option value="5">05:00 A.M.</option>
                            <option value="6">06:00 A.M.</option>
                            <option value="7">07:00 A.M.</option>
                            <option value="8">08:00 A.M.</option>
                            <option value="9">09:00 A.M.</option>
                            <option value="10">10:00 A.M.</option>
                            <option value="11">11:00 A.M.</option>
                            <option value="12">12:00 P.M.</option>
                            <option value="13">01:00 P.M.</option>
                            <option value="14">02:00 P.M.</option>
                            <option value="15">03:00 P.M.</option>
                            <option value="16">04:00 P.M.</option>
                            <option value="17">05:00 P.M.</option>
                            <option value="18">06:00 P.M.</option>
                            <option value="19">07:00 P.M.</option>
                            <option value="20">08:00 P.M.</option>
                            <option value="21">09:00 P.M.</option>
                            <option value="22">10:00 P.M.</option>
                            <option value="23">11:00 P.M.</option>
                        </select>
                    </div>

                    <!-- End Hour -->
                    <div class="select-wrapper">
                        <label>End Hour</label>
                        <select name="end" required>
                            <option value="" disabled selected>Select Your End Hour</option>
                            <option value="12">12:00 P.M.</option>
                            <option value="13">01:00 P.M.</option>
                            <option value="14">02:00 P.M.</option>
                            <option value="15">03:00 P.M.</option>
                            <option value="16">04:00 P.M.</option>
                            <option value="17">05:00 P.M.</option>
                            <option value="18">06:00 P.M.</option>
                            <option value="19">07:00 P.M.</option>
                            <option value="20">08:00 P.M.</option>
                            <option value="21">09:00 P.M.</option>
                            <option value="22">10:00 P.M.</option>
                            <option value="23">11:00 P.M.</option>
                        </select>
                    </div>

                    <!-- Weather -->
                    <div class="select-wrapper">
                        <label>Weather</label>
                        <select name="weather" required>
                            <option value="" disabled selected>Select Weather</option>
                            <option value="1">Sunny ☀️</option>
                            <option value="0">Rainy 🌧️</option>
                        </select>
                    </div>

                    <!-- Route -->
                    <div class="select-wrapper">
                        <label>Route</label>
                        <select name="route" required>
                            <option value="" disabled selected>Select Route</option>
                            <option value="1">Route 1 — San Pablo City to Tanauan</option>
                            <option value="2">Route 2 — San Pablo to Wawa</option>
                        </select>
                    </div>

                    <!-- Capacity -->
                    <div class="select-wrapper">
                        <label>Capacity</label>
                        <select name="cap" required>
                            <option value="" disabled selected>Select Jeepney Capacity</option>
                            <option value="17">17 seater</option>
                            <option value="19">19 seater</option>
                            <option value="21">21 seater</option>
                        </select>
                    </div>

                </form>
            </div>
        </section>

        <!-- History Panel -->
        <section id="history" style="display:none;width:100%;max-width:420px;">
        <h2 style="text-align:center;margin:6px 0 12px 0;color:#222">Prediction History</h2>
        <div id="historyList" class="history-list" aria-live="polite"></div>
        </section>

        <!-- About Panel -->
        <section id="about" class="panel" style="display:none;">
    <div class="about-card">
        <h2>About</h2>

        <p class="muted">
            Jeepney ML is designed to help <strong>jeepney drivers</strong> estimate their possible 
            <strong>passenger count</strong> and <strong>total gross fare</strong> based on different conditions.
        </p>

        <p class="muted">
            Using machine learning, the app analyzes factors such as month, day, weather, route, and time 
            to help drivers make smarter decisions before starting their trip.
        </p>

        <hr style="border: none; border-bottom: 1px solid #ccc; margin: 18px 0; opacity: .3;">

        <h3 style="margin: 6px 0 10px; font-size: 17px;">Developer Team</h3>

        <p class="muted" style="line-height:1.6;">
            • <strong>Avenido, Joemer</strong><br>
            • <strong>Blas, Jay Bryan</strong><br>
            • <strong>Guk-Ong, Gabriel</strong>
        </p>
    </div>
</section>

    </div>

    <!-- Bottom Predict Button -->
    <div id="actionBtn" class="action-btn-container">
        <button class="action-btn" form="predictForm" type="submit">Predict Now</button>
    </div>

    <!-- Bottom Navigation -->
    <div class="bottom-nav">
        <div class="nav-btn active" onclick="showSection('predict')">
            <span class="material-icons">calculate</span>
            Predict
        </div>
        <div class="nav-btn" onclick="showSection('history')">
            <span class="material-icons">history</span>
            History
        </div>
        <div class="nav-btn" onclick="showSection('about')">
            <span class="material-icons">info</span>
            About
        </div>
    </div>

    <script>
        function showSection(id) {
            ['predict', 'history', 'about'].forEach(sec => {
                document.getElementById(sec).style.display = (sec === id) ? '' : 'none';
            });

            document.querySelectorAll('.nav-btn').forEach((btn, i) => {
                btn.classList.remove('active');
                if ((id === 'predict' && i === 0) ||
                    (id === 'history' && i === 1) ||
                    (id === 'about' && i === 2)) {
                    btn.classList.add('active');
                }
            });

            const action = document.getElementById('actionBtn');
            action.style.display = (id === 'predict') ? 'block' : 'none';

            if (id === 'history') loadHistory();

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

 function formatDate(dateString) {
    const date = new Date(dateString.replace(' ', 'T'));

    return date.toLocaleString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    });
}

function loadHistory() {
    const list = document.getElementById('historyList');
    list.innerHTML = '';

    fetch('getHistory.php')
        .then(response => response.json())
        .then(history => {
            if (!history.length) {
                list.innerHTML = `
                    <div class="history-item">
                        <em class="muted">No history yet</em>
                    </div>`;
                return;
            }

            history.forEach(h => {
                const routeLbl = (h.route === "Route 1 (San Pablo → Tanauan)")
                    ? 'Route 1 — San Pablo City to Tanauan'
                    : 'Route 2 — San Pablo to Wawa';

                // Robust weather label
                let weatherLbl;
                if (Number(h.weather) === 1) weatherLbl = 'Sunny ☀️';
                else if (Number(h.weather) === 0) weatherLbl = 'Rainy 🌧️';
                else weatherLbl = 'Unknown';

                list.innerHTML += `
                    <div class="history-item">
                        <strong>${formatDate(h.time)}</strong><br>
                        <div><span class="muted">${routeLbl} • ${weatherLbl}</span></div>
                        <div>👥 <strong>Passengers:</strong> ${h.passengers}</div>
                        <div>💰 <strong>Total Fare:</strong> ₱${h.fare.toLocaleString()}</div>
                    </div>
                `;
            });
        })
        .catch(error => {
            console.error('Error fetching history:', error);
            list.innerHTML = `
                <div class="history-item">
                    <em class="muted">Failed to load history</em>
                </div>`;
        });
}
// --- CLEAN DARK MODE CONTROLLER ---
const body = document.body;
const themeToggle = document.getElementById("themeToggle");
const themeIcon = document.getElementById("themeIcon");

// Load saved theme
function applyTheme(mode) {
    if (mode === "dark") {
        body.classList.add("dark");
        themeIcon.innerText = "dark_mode";
    } else {
        body.classList.remove("dark");
        themeIcon.innerText = "light_mode";
    }
}

applyTheme(localStorage.getItem("theme"));

// Click toggle
themeToggle.addEventListener("click", () => {
    const dark = body.classList.toggle("dark");
    localStorage.setItem("theme", dark ? "dark" : "light");
    themeIcon.innerText = dark ? "dark_mode" : "light_mode";
});

        document.addEventListener('DOMContentLoaded', () => showSection('predict'));
    </script>
</body>
</html>
