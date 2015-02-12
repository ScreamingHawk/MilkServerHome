rem This script builds from the HEAD not from the local machine
del /f build*.zip
for /f %%i in ('git rev-parse HEAD') do set commitId=%%i
git archive --format=zip HEAD > build_%commitId%.zip

