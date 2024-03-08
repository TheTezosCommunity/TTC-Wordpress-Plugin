# Front-end Scripts Documentation (`fe-scripts.js`)

The `fe-scripts.js` file is a custom JavaScript file included in the "TTC Website" WordPress plugin. It primarily enhances the user interaction and presentation of event-related content on the front end. This script leverages jQuery to manipulate elements and respond to user actions effectively.

## Features

The script includes several key functionalities:

1. **Adjustment of Event Data Position**: For screens wider than 480 pixels, it dynamically adjusts the margin-top of the event details section based on the height of the event's image. This ensures that the event details are visually aligned with the event image, enhancing the layout on larger screens.

2. **Clickable Event Images**: Within the daily view of events (`mec-daily-view-dates-events`), it makes event images clickable, redirecting the user to the event's detailed page. This feature improves user navigation and accessibility by allowing images to serve as additional links to the event details.

## Usage

### Event Data Position Adjustment

On pages displaying single event details (identified by the `.mec-single-event` class), the script calculates the height of the event's image. It then sets the `margin-top` CSS property of the event details container (`.col-md-8`) to a negative value based on the image height plus an additional 85 pixels. This adjustment is made only if the viewport width is 480 pixels or wider, ensuring that the layout is optimized for larger screens while remaining unaffected on smaller devices.

### Clickable Event Images

In the daily event view section (marked by `.mec-daily-view-dates-events`), the script iterates through each event article (`mec-event-article`). For every event article, it binds a click event listener to the event's image. When an image is clicked, the script triggers a click on the first link within the event title (`mec-event-title a`), effectively redirecting the user to the event's detail page.
