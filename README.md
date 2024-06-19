# Budgeteer

A simple webapp to track finances

## TODO

- [x] add budget entity
- [x] basic crud of transactions
  - [x] create
  - [x] read
  - [x] update
  - [x] delete
- [x] transactions are assigned to the budget
- [x] transactions are deducted from budget
  - [x] normal ones are substracted
  - [x] reimbursements are added back
- [ ] budget dashboard
  - [x] list of all transactions
  - [x] transactions have edit/delete button
  - [x] total view of spending / reimbursement
- [ ] make everything look nice
  - [x] navigation
    - [x] logo
    - [x] page links
  - [ ] footer
    - [ ] copyright?
    - [ ] links
  - [ ] dashboard
    - [ ] nice header with current budget value
    - [ ] every transaction is a element of the structure (table? list? grid?)
    - [ ] transaction is colored based on the impact on the budget (red / green?)

for later
- [ ] budget graph
  - [ ] graph is disaplyed next to the budget value
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
- [ ] 
  - [ ] 
    - [ ] 

## Technology
- Symfony (duh)
- SQLite
- HTMX
- FrankenPHP ?
- Stimulus / Turbo ?
    - for simple dom manipulation
