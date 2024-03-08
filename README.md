# estatik-bookings

Custom Wordpress plugin named Estatik Bookings.

Requirments:
- Create a custom post type - booking.
- Create a metabox for this post type and add custom fields there - start date, end date, address (Property address).
- Add date picker support for date fields using default wp date picker library.
- Implement this metabox in a separate template file.
- Save date fields as post meta data in timestamp format.
- Save address field as post meta.
- Display date fields in format like 25 Dec 2023 21:00 and add these at the end of the post content on a single booking page.
- Add google map with marker using address field after date fields.

Installation:
- Clone repository to your wp-content/plugins folder
- Open file: wp-content/plugins/estatik-bookings/admin/class-estatik-bookings-admin.php
- Find string "YOUR_API_KEY_HERE" and replace it with your Google Javascript Maps API key
- Go to the admin panel -> plugins and activate "Estatik Bookings" plugin
- Now you can manage bookings in the "Bookings" menu item
- Enjoy! =)
