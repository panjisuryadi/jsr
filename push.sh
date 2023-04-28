git config --global user.email "n0izestr3am@gmail.com"
git config --global user.name "n0izestr3am"
#
git add .

echo 'Judul:'
read commitMessage

git commit -a -m "$commitMessage |  `date +%F-%T`"
#
current_branch=$(git branch | sed -n -e 's/^\* \(.*\)/\1/p')
git push origin "$current_branch"
echo "===== '$current_branch' branch"
read
