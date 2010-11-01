require 'date'

class Date
  def self.last_of_month date
    last = new d.year, d.month
    last += 42                  # warp into the next month
    new(last.year, last.month) - 1 # back off one day from first of that month
  end
  
  def self.first_of_month date
    first = new(date.year, date.month)
  end
end