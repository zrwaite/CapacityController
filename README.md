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

## Inspiration
Several of our group members work in grocery stores, and all of us have seen the impact of COVID with how consumers interact with businesses. Being able to find a less crowded location is important, and this seemed like a simple yet scalable way to make a difference
## What it does
Our product allows business to keep track of the capacity in their store with a manual clicker system on a phone or computer, or even allows the process to be automated with our scanner hardware that tells when someone enters a door. 
## How we built it
The hardware was built with IR scanners, plywood, wiring, arduinos, power supply, LEDs, etc. Our system lies flat for storage and shipping, then folds out to allow a passage way for people to walk through. The sensors send wired signals to the arduino, which reads this information, parses it, and determines if a signal needs to be sent. 
The software was not able to be fully implanted in the time frame, but it takes requests to the server from businesses to update their status. An admin page also allows for edits to things like address, and the max capacity. Businesses can keep track of how many people are in their store between all of their workers, but an even larger benefit is to customers. The data about capacity will be publicly available, meaning that you can see how busy stores in your area are before you go there. Stores that are very busy can't accept more people anyways, so it isn't a detriment to them. Stores that aren't busy, especially small business, can benefit from people being assured about their safe experience. 
## Challenges we ran into
- Radio signal stopped working
- Losing track of wires through pipes etc
- Raspberry pi server wasn't working
- Couldn't read GPIO data
- Timeframe
- SQL SELECT with prepared statements was not working, so registration was not implemented on time
- Tiredness
- Team members getting distracted
- Blew out dozens of LEDs
- Front-end was hard to implement without any libraries
## Accomplishments that we're proud of
The sensor system with the arduino was able to easily parse data about when people walked through, because people give off more IR then objects, so rolling a cart through would not be detected as another person. 
The front-end design was very good. We were not able to implement all of it, but it was very nice looking.
## What we learned
Certain team members learned more than others, but we learned a lot about raspberry pi and arduino, implementing front-end systems and back-end code, sql query and javascript with query. We also learned about soldering and hardware components in our assembly process. 
## What's next for Capacity Controller
Fixing those errors. The back-end can be implemented with a bit more time, allowing businesses to add their information and add users to control input and output data. We can then add the raspberry pi data directly to the server using GPIO. 

## Hardware description
Coming up with the components for our capacity counter was one of the most important parts of the project, and thus took a lot of planning. We had initially thought to put the sensors at the sides of a doorway, or on a vertical wood plank, however that would’ve been inconvenient, and hard to move. Therefore we came up with a contractible design, which could fold in on itself, being easier to carry and transfer. On the edge of each foldable board, we added 1 sensor, attached to wires which travel throughout the design to obtain both a power supply, and code from an arduino. The code would input information to a series of 3 coloured lights, all representing the state of the line and grocery store. If no one has entered the store in a while the light will be green (customers are allowed in 1 at a time). If a customer has just entered the store, the light will change to white for 4 seconds (meaning no one can enter), soon changing back to green. Finally, if the store is at maximum capacity, the light will stay red until someone from the store has left (detected by a sensor at the exit door). 
![IMG_5969](https://user-images.githubusercontent.com/68486874/123549560-ad8ffd00-d737-11eb-8087-cc88830fdd0e.jpeg)


When using the sensors, we noticed that inanimate objects wouldn’t be detected at a far range by the sensor, however due to the IR humans give off, we were detectable at distances up to 3 metres, working perfectly for our design. We had also designed antennas for our transmitters/receivers and were able to transfer signals at a distance of 5 metres. 

![IMG_5968](https://user-images.githubusercontent.com/68486874/123549574-b4b70b00-d737-11eb-9ff3-1ae74557ba06.jpeg)


## Website Pages:
* Home/Landing
<img width="685" alt="home" src="https://user-images.githubusercontent.com/68486874/123548027-20e24080-d731-11eb-9a33-ca742f109fcc.png">
* Sign up/Registration
<img width="967" alt="registration" src="https://user-images.githubusercontent.com/68486874/123548034-2b043f00-d731-11eb-986f-89791dc93958.png">
* Log in
<img width="961" alt="login" src="https://user-images.githubusercontent.com/68486874/123548038-2e97c600-d731-11eb-8949-90102d7df819.png">
* Admin Page
<img width="1270" alt="admin" src="https://user-images.githubusercontent.com/68486874/123548044-322b4d00-d731-11eb-8ee8-68a52dfb0052.png">
* Controller Page
<img width="1264" alt="controller" src="https://user-images.githubusercontent.com/68486874/123548048-35bed400-d731-11eb-9bdc-8cb9289b0513.png">
* About Us
<img width="1269" alt="about" src="https://user-images.githubusercontent.com/68486874/123548052-39eaf180-d731-11eb-93f2-c895ca471570.png">
* Stores
  * <img width="1348" alt="Screen Shot 2021-06-27 at 10 14 53 AM" src="https://user-images.githubusercontent.com/68486874/123547920-b4674180-d730-11eb-9533-587b673ed1a0.png">
* Contact Us


## Website
All of the code is written from scratch. The only library used is JQuery, the entire site is written in pure HTML, CSS, Javascript and PHP, with nothing written before the start of the time. 

<img width="1483" alt="code" src="https://user-images.githubusercontent.com/68486874/123548073-4e2eee80-d731-11eb-8e9f-3b3dd827019e.png">

Due to time constraints, we were not able to implement many of the features we planned to. Sign in and registration for business customers was not implemented in time, due to some issues with mysqli. The admin and controller pages therefore were not able to have back-end implemented in time. 

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
