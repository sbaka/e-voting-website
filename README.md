# e-voting-website
evoting website made with HTML CSS JS and PHP using WAMPP server  
## made for a uni project:
the purpose was to practice php and SQL request, it's very simple and straight forward. not for professional use just to demonstrate skills
## screens of the website
![candidature](https://user-images.githubusercontent.com/62220111/168678536-77b54639-a703-475b-8ce5-59b536c2cf77.gif)
![vote](https://user-images.githubusercontent.com/62220111/168678632-ba2aaace-d7dd-415b-b017-4659fbb5dc22.gif)
![results(1)](https://user-images.githubusercontent.com/62220111/168678678-1354db6b-7574-400a-a613-3d97a5c6452e.gif)
## how it works
the website is devided into 3 "screens":
### login/register
first there is a login/register page, you enter ur info and then you choose either you want to be a candidate or just a simple voter. only the 5 first persons who check the "be candidat" box well be actual candidat, before that you'll be wating on a some sort of waiting screen until all 5 candidate are chosen for the vote to begin.
![candidature](https://user-images.githubusercontent.com/62220111/168679475-81791615-8da0-4dcc-8f24-22e73dc3cd99.gif)
### voting
choose a candidat from the existing 5, and you won't be able to change the vote once it's submitted
![vote](https://user-images.githubusercontent.com/62220111/168678632-ba2aaace-d7dd-415b-b017-4659fbb5dc22.gif)
### results 
the results are shown in a pie format as shown bellow, to see the results after the vote, you just need to log in again to be redirected to that screen.
![results(1)](https://user-images.githubusercontent.com/62220111/168678678-1354db6b-7574-400a-a613-3d97a5c6452e.gif)

## there is a trick
the pages aren't really changing, i don't know about performance impact this has, but at the time of making this it seemed like a good idea. So the page is the same i change what's displayed on the screen according to the users interactions by changing the opacity of the divs. 
