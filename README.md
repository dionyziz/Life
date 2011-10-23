== About ==
Life is a simple minimalistic personal journal keeping software. It allows
you to keep a record of your thoughts using a plain web interface. It
is intended for personal use, a digital format of a handwritten journal.

Life is not Facebook. It is not intended for your friends to see; although
some or even all of your posts can be public, the main intention of
the software is for you to use it for yourself, to keep track of your
memories and what happened in your past.

Life is not Twitter. Noone can follow you, you can't follow anyone,
and there's no character limit; it's a piece of software designed for
you to use for your own enjoyment and purposes.

I developed life because I have been keeping a handwritten journal for
some time, and I wanted to make it searchable and protect it from being
lost or destroyed. I use my journal to log my personal adventures as well
as my notes as an entrepreneur, including information about what I do,
places I go, people I meet, and things I see.

Life isn't a blog. It doesn't have features such as comments, a complex
WYSIWYG editor, or anything of the like. It lets you post simple,
unformatted pieces of text. Think of it as a list of Skype messages sent
to an imaginary friend that never responds.

== Installation ==
Rename settings-sample.php to settings.php and edit it to include
your database credentials. Run life.sql to create the schema of your
Life database. If you need Picasa integration, download the Zend Gdata
library into the models folder and add it to your include path. Then
insert a row into the users table using an MD5 hashing without salt for
the password. Finally, login and make your first post.

== TODO ==
This project isn't completed yet. I am planning to add the following
features in the future:
* Gmail integration
* Facebook integration
* Twitter integration
* Google calendar integration
* Google contacts integration
* Picasa integration
* Post pagination
* Calendar view and time ranges
* Post editing

