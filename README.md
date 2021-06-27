# DefHacks3: CapacityController
This is our code repository for our project submission for Def Hacks Worldwide 3.0

## Team Members:
* Zac: Software Engineer and Leader
* Luke: Hardware Engineer
* Greyson: Design and Engineer
* Kellan: Design and Engineer

## Project Description:
While identifying covid-related issues in our community, one problem that came to mind were the excessive lineups stores accumulate due to capacity restrictions, as well as the inability to accurately keep track of total occupants in a given store. Brainstorming several ideas for this solution, engineers Zac, Kellan, Luke and Greyson were able to come up with a solution; While using distance sensors to keep track of how many people leave/enter a store, this information can then be transferred to a server which can keep track of current capacities of any nearby stores, as well as comparing the current capacities with one another. Once we finished designing a hardware prototype, we began creating templates for the pages of our website, which we could code soon after. We wanted to make sure that the website would allow for the sensors to input information to our servers, analyzing the data itself in various pie charts, and statistics. We had hoped that the sensors would transfer data to a radio signal, eventually leading to our server, however due to multiple difficulties with the radio, and code, we were unable to do so. That would definitely be one of our greatest next steps, as that would give users the ability to compare the capacities of all grocery stores, deciding which to go to.

The project consisted of many ups and downs, and a lot of things came unexpectedly. A lot of our technology was limited due to covid/budgeting, some of our equipment was malfunctioning, and there were some problems that we were not quite able to solve in the given time frame.


## Hardware description
Coming up with the components for our capacity counter was one of the most important parts of the project, and thus took a lot of planning. We had initially thought to put the sensors at the sides of a doorway, or on a vertical wood plank, however that would’ve been inconvenient, and hard to move. Therefore we came up with a contractible design, which could fold in on itself, being easier to carry and transfer. On the edge of each foldable board, we added 1 sensor, attached to wires which travel throughout the design to obtain both a power supply, and code from an arduino. The code would input information to a series of 3 coloured lights, all representing the state of the line and grocery store. If no one has entered the store in a while the light will be green (customers are allowed in 1 at a time). If a customer has just entered the store, the light will change to white for 4 seconds (meaning no one can enter), soon changing back to green. Finally, if the store is at maximum capacity, the light will stay red until someone from the store has left (detected by a sensor at the exit door). 

When using the sensors, we noticed that inanimate objects wouldn’t be detected at a far range by the sensor, however due to the IR humans give off, we were detectable at distances up to 3 metres, working perfectly for our design. We had also designed antennas for our transmitters/receivers and were able to transfer signals at a distance of 5 metres. 

## Website Pages:
* Home/Landing
* Sign up/Registration
* Log in
* Admin Page
* Controller Page
* About Us
* Contact Us
* Stores

## Website Back-end

### Account creation
* Takes registration information, adds to table
### Log in
* Takes username and password, confirms, returns jwt and routes to appropriate page
### Admin 
* Confirm token, return store info
* Allow for edits to many different store info aspects, updates table
### Controller page
* Confirm token, return store info
* Allow for increment and decrement of store availability, updates table
### Store page
* Return all store info
### Contact page
* Takes email, name, and message, sends us an email

## Project contacts
General: capacitycontroller@gmail.com
Zac: 129032699zw@gmail.com
Greyson: greysonmartyn@gmail.com
Luke: lpgabc123@gmail.com
Kellan: kmac1792@gmail.com
