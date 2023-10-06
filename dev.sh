git config --global user.email "n0izestr3am@gmail.com"
git config --global user.name "n0izestr3am"
#
git stash
git pull origin dev
git stash pop

git add .


echo 'Judul:'
read commitMessage

git commit -a -m "$commitMessage |  `date +%F-%T`"
#
# Push changes to remote repository
git push origin dev