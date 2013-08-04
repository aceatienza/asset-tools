
ISSUES
Can embed videos only on the domain and handle authentication from Laravel
CAN'T embed portfolios. Portfolio API doesn't exist.
https://vimeo.com/forums/topic:40958
https://vimeo.com/forums/topic:31238
https://vimeo.com/forums/topic:42986


Video Settings > Privacy > tick Hide this video from Vimeo.com && tick Only on sites I choose, with subdomain
> API: vimeo.videos.getByTag
*** the only way I this will work is if we use tags, which defeats the purpose of organization

hack: embed a separate player instance using an iframe for each video
possible to get private videos through the API, just not the "Use your own player" URL

http://stackoverflow.com/questions/735072/how-can-i-get-a-parent-windows-height-from-within-iframe-using-jquery
http://vimeopro.com/brooklynfoundry/test-portfolio-title

If iframe
- remove the headers with css display none
- add transition, then while that is working use javascript to get width/height and adjust if needed

Goal: [Vimeo] either password protect those videos or have those videos only embeddable on the domain that you are embedding on, but you would have to handle the authentication to confirm that only clients view that domain

FIRST you set a video's privacy to "None." (This removes it from any albums/etc.)
THEN you add the video to a private album.
access a video's settings, you can specify which domains that video is allowed to be embedded on.
available to Pro users

will need to compile together Portoflios on BF end
- get thumbnails for private videos through the Advanced API. 
-retrieve information on private videos with the Advanced API


https://vimeo.com/forums/topic:40958
FOR ANYONE WANTING MULTIPLE PORTFOLIOS WITHOUT CREATING NEW SUBDOMAINS: Use wildcard sub-subdomains!! Once you set it up, you can create as many portfolios as you want with custom URLs without having to edit any zone files.
To get it working, you have to create a new A Record or CNAME record in your website's DNS manager. Either will work. Vimeo suggests a CNAME record. Godaddy can only do A records.
First choose your subdomain. This will be the same for all your URLs, so make it something like "portfolios" or "playlists". Your URLs will look like 3dreel.portfolios.example.com.
Now to edit the DNS on your website. If you're doing an A record, it will look like *.portfolios pointing to 74.113.233.155 (Vimeo's IP). For a CNAME, *.portfolios will point to vimeopro.com.
Once the changes take effect (5 minutes - 3 days), you can set your portfolios to use custom URLs! Note that they must have .portfolios.example.com after them (or whatever subdomain you chose).