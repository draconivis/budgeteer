# Budgeteer

A simple webapp to track finances

## TODO

- [x] add budget entity
- [ ] basic crud of transactions
  - [ ] create
  - [ ] read
  - [ ] update
  - [ ] delete
- [ ] transactions can be assigned to a budget
- [ ] transactions are deducted from budget
  - [ ] normal ones are substracted
  - [ ] reimbursements are added back
- [ ] budget dashboard
  - [ ] list of all transactions
  - [ ] transactions have edit/delete button
  - [ ] total view of spending / reimbursement
  - [ ] 
- [ ] 
- [ ] 
- [ ] 

## Requirements

### MVP
- [ ] ONE continuous budget
  - one "user" per instance
  - no start / end date
  - CANNOT be edited directly
- [ ] User can track expenses / reimbursements
  - These count against the budget

### Further
- [ ] profiles
   - user can switch between profiles
- [ ] transaction tagging
- [ ] data visualization
  - overview of historical data
  - analysis of data

## Technology
- Symfony (duh)
- SQLite
- HTMX
- FrankenPHP ?
- Stimulus / Turbo ?
    - for simple dom manipulation
