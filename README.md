# mjeepl

## Description

**mjeepl** is a PHP-based web application designed for the predictive analysis of jeepney operations in San Pablo, Laguna. By analyzing various input factors such as the day of the week, weather conditions, route, and jeepney capacity, the system predicts key metrics such as the total gross fare and the number of passengers for a given day.

---

## Features

- Predicts the **total number of passengers per day**
- Predicts the **total gross fare of a jeepney per day**
- Uses **Least Squares Linear Regression** for prediction
- Accepts the following user inputs:
  - Month
  - Day of the Week
  - Weather
  - Start Hour
  - End Hour
  - Route
  - Jeepney Capacity
- Processes historical datasets stored in CSV format
- Machine learning model persistence (save/load)
- Clean, Material-inspired user interface
- Lightweight and fast (no heavy frontend frameworks)

---

## Installation

### Prerequisites
- PHP 7.4+
- Composer (PHP package manager)
- Modern web browser (Chrome, Edge, Firefox)

### Install dependencies using Composer

If you don’t have Composer installed, follow the installation instructions from [here](https://getcomposer.org/download/).

Once Composer is installed, run the following to install the required libraries, including `php-ai/php-ml` for machine learning functionality.

### Set up the environment:
- Ensure your PHP environment has the necessary core extensions enabled (e.g., `fopen`, `fgetcsv`, `round`, `number_format`).
- No additional configuration files are required unless you need to tweak PHP settings.

### Running the application:
- After the dependencies are installed, start your PHP server locally, and the application will be accessible at `http://localhost:8000`.

---

## Usage

- The system allows users to input various parameters such as:
  - Month
  - Day of the week
  - Weather
  - Start and end hours
  - Route
  - Capacity of the jeepney
- After entering the required data, users will receive predictions for the total passengers and gross fare of the jeepney for the given day.

---

## Developers

- **Avenido Jr., Joemer A.**
- **Blas, Jay Bryan R.**
- **Guk-ong, Gabriel G.**

---

## Project Purpose
This system was developed as a **final academic requirement**. Its purpose is to demonstrate the application of machine learning in predictive analytics for jeepney operations. The system is intended strictly for academic and research purposes.

---

## Links

- **[Screenshots](./screenshots/)** – Link to screenshots of the application.
- **[Deployed System](https://mjeepl.ct.ws)** – Link to the live deployed system.
- **[Video Presentation](https://youtu.be/arEMuotw6qw)** – Link to the video presentation.
- **[Canva/PowerPoint](https://www.canva.com/design/DAG7Q1Ig2c8/8VfP8murG-atPHjPNQL_sg/view?utm_content=DAG7Q1Ig2c8&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=h5c1b44d765)** – Link to the Canva/PowerPoint presentation

---

## Author
**jmravnd**

---

## License
**School-use only.**  
This project is intended strictly for academic purposes and may not be used for commercial purposes, redistribution, or modification outside of academic requirements.


