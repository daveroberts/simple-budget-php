# Filters added to this controller apply to all controllers in the application.
# Likewise, all the methods added will be available for all controllers.

class ApplicationController < ActionController::Base
  helper_method :current_user_or_first, :logged_in?
  # Pick a unique cookie name to distinguish our session data from others'
  session :session_key => '_SimpleBudget_session_id'
  def logged_in
    session[:person_id] != nil
  end

  def logged_in?
    session[:person_id] != nil
  end

  def current_user_or_first
    if logged_in
      Person.find session[:person_id]
    else
      Person.find :first
    end
  end
  
  def get_date_range
    if request.post?
      from_date = Date.strptime(params[:from_date], '%Y-%m-%d')
      to_date = Date.strptime(params[:to_date], '%Y-%m-%d')
    elsif params[:from_year] and params[:from_month] and params[:from_day] and params[:to_year] and params[:to_month] and params[:to_day]
      from_date = Date.new(params[:from_year].to_i, params[:from_month].to_i, params[:from_day].to_i)
      to_date = Date.new(params[:to_year].to_i, params[:to_month].to_i, params[:to_day].to_i)
    end
    return from_date, to_date
  end
end
