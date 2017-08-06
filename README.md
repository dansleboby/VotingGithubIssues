# VotingGithubIssues
A little app in Laravel to vote for next feature we will develop base on github issues of a repersitory

# Installing
- Download and unzip archive
- Run `composer install`
- You may add change this value in .env and configure mysql informations
```
 SITE_NAME="TITLE OF SOTE"
 VOTE_LIMIT=5 #Max item open user can vote, if an feature update to closed the user will automatically regain his votes
 LABEL_TO_VOTE="feature request" #Label to votes in issues
 REPERSITORY_TO_WATCH="" #username/repersitory
 ACCESS_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxx #Github access token (https://github.com/blog/1509-personal-api-tokens)
 
 OAUTH_ENABLE=github,facebook,twitter,google # We use only social login to prevent fake user, we choose Laravel socialite you can enable many login as you want separate with ","
 
 GITHUB.CLIENT_ID=
 GITHUB.CLIENT_SESCRET=
 
 GOOGLE.CLIENT_ID=
 GOOGLE.CLIENT_SESCRET=
 
 TWITTER.API_KEY=
 TWITTER.API_SECRET=
 
 FACEBOOK.APP_ID=
 FACEBOOK.APP_SECRET=
 ```
 - Run `php artisan migration`
 - Run `php artisan github:sync`
 - Add this cron (to sync github issues)
 ```
 * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
 ```
 - Now you should ready to go :)

# Todos
- Add texts in language file
- Optimise javascript with a frontend framework
- Add search
- Unit test