Given /^the query "(.*)"$/ do |query|
  @da_query = query
end

When /^the driver runs the query$/ do
  # must enclose query in double-quotes so that the
  # shell doesn't interpret special characters like *
  @output = `echo "#{@da_query}" | ./sql-driver.php`
  raise('Command failed execution') unless $?.success?
end

Then /^the output should match "(.*)"$/ do |expected|
  # replace all \n with the actual newline character to
  # make sure the output lines up correctly
  expected = expected.gsub("\\n","\n")
  if @output != expected
    puts "Expected:", expected
    puts "Got back:", @output
    raise('Query didn\'t match expected')
  end
end
