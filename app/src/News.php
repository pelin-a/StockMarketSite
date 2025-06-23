@startuml

class User {
  +int id
  +string username
  +string email
  +string passwordHash
  +datetime createdAt
  +datetime lastLogin
  +float accountBalance
  +bool isActive
  +register(data)
  +login(username, password)
  +getPortfolio()
}

class Portfolio {
  +int id
  +int userId
  +datetime createdAt
  +array holdings
  +addStock(stock, quantity, price)
  +removeStock(stock, quantity)
  +calculateValue()
}

class Stock {
  +string symbol
  +string companyName
  +string exchange
  +float currentPrice
  +string currency
  +float previousClose
  +float openPrice
  +float dayHigh
  +float dayLow
  +int volume
  +float marketCap
  +float peRatio
  +float dividendYield
  +datetime lastUpdated
  +fetchPrice()
  +getDetails()
}

class News {
  +int id
  +string symbol
  +string title
  +string summary
  +string url
  +string source
  +datetime publishedAt
  +string imageUrl
  +fetchNews(symbol)
}

User "1" --> "1" Portfolio : owns
Portfolio "*" --> "*" Stock : holds
News "*" --> "0..1" Stock : relates to

@enduml
