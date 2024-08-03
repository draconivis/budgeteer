# Budgeteer

A (very) simple webapp to track finances.

I wanted to play around with htmx and symfony, so here we are.

## technologies

- symfony
- htmx
- tailwind
- sqlite

color palette is [catpuccin](https://catppuccin.com/)

## resources that helped me out:

- [making a spa with htmx and symfony](https://jolicode.com/blog/making-a-single-page-application-with-htmx-and-symfony)
- [htmx & symfony: the pleasure of purified web development](https://lukasrotermund.de/posts/symfony-and-htmx-poc/) | [the poc repo](https://github.com/tasko-products/poc-symfony-htmx)

## further possible improvements

- [ ] budget graph
  - [ ] graph is displayed next to the budget value
  - [ ] transaction of the last seven days are used
  - [ ] grouped by day + hours
- [ ] tagging
  - [ ] there are tags that can be assigned to transactions
  - [ ] can be assigned at transaction creation or added afterwards
  - [ ] multiple tags can be assigned
  - [ ] input field
    - [ ] entering something fuzzy finds existing tags
    - [ ] user can select one of the existing ones
    - [ ] if no matches are found, the entered value becomes a new tag
- [ ] i18n
  - [ ] user can switch between english/german
  - [ ] every text is translated
  - [ ] routes? (probably not)
- [ ] dark mode
  - [ ] user can switch between light/dark mode
