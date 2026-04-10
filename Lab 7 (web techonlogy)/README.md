# Lab 7: Web Technology Activities

This repository contains a series of lab activities focused on understanding and implementing JavaScript timing functions: `setTimeout()`, `clearTimeout()`, `setInterval()`, and `clearInterval()`.

## Activities Overview

### 1. Activity 01: setTimeout Demo
- **File:** [activity01.html](activity01.html)
- **Description:** This activity demonstrates the use of the `setTimeout()` function. When the user clicks the "Show Message" button, a function is scheduled to execute after a 3-second (3000ms) delay, displaying a greeting message.
Activity 01 OutPut:
<img width="1525" height="904" alt="Screenshot 2026-03-17 130829" src="https://github.com/user-attachments/assets/0fc6447d-0692-4792-b7b3-ac21dc4cc970" />

### 2. Activity 02: clearTimeout Demo
- **File:** [activity02.html](activity02.html)
- **Description:** This activity demonstrates how to cancel a scheduled task using `clearTimeout()`. 
    - Clicking **Start Timer** schedules a message to appear in 5 seconds.
    - Clicking **Stop Timer** calls `clearTimeout()`, which prevents the scheduled message from appearing if clicked before the 5 seconds are up.
Activity 02 Out Put:
<img width="1207" height="635" alt="Screenshot 2026-03-17 131114" src="https://github.com/user-attachments/assets/10cb448f-9b49-4698-bef7-526cfd82c440" />
<img width="1164" height="771" alt="Screenshot 2026-03-17 131127" src="https://github.com/user-attachments/assets/69dfb44e-f6bc-43b3-91f2-2692de15f054" />

### 3. Activity 03: setTimeout & setInterval (Real-Time Clock)
- **File:** [activity03.html](activity03.html)
- **Description:** This file contains two distinct lab activities:
    - **Lab Activity 1:** Another demonstration of `setTimeout()` that shows a message after 3 seconds.
    - **Lab Activity 3:** A real-time clock implemented using `setInterval()`. The clock updates every second (1000ms) to display the current system time in `HH:MM:SS` format.
Activity 04 Out Put:
<img width="1123" height="913" alt="Screenshot 2026-03-17 131435" src="https://github.com/user-attachments/assets/4f3e0989-436a-49de-b832-62e65a152d90" />


### 4. Activity 04: setInterval & clearInterval (Stop Clock)
- **File:** [activity04.html](activity04.html)
- **Description:** This activity enhances the real-time clock from Activity 03 by adding control functionality.
    - The clock starts automatically when the page loads.
    - A **Stop Clock** button is provided, which uses `clearInterval()` to halt the timer and stop the clock from updating.

## Core Concepts Covered

- **`setTimeout(function, delay)`**: Executes a function once after a specified delay (in milliseconds).
- **`clearTimeout(timeoutID)`**: Cancels a timeout previously established by calling `setTimeout()`.
- **`setInterval(function, interval)`**: Repeatedly executes a function at fixed time intervals (in milliseconds).
- **`clearInterval(intervalID)`**: Cancels a repeating action previously established by calling `setInterval()`.
  Activity 04 Out put:
  <img width="1545" height="849" alt="Screenshot 2026-03-17 131910" src="https://github.com/user-attachments/assets/a57701bb-87c0-4c49-b0b2-7def5e3e31df" />

## How to Run

To view these activities, simply open any of the HTML files in a modern web browser (Chrome, Firefox, Edge, etc.).
