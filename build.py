from shutil import copyfile
copyfile('lng/cs.ini', 'lib/timetable_cs.ini')
copyfile('lng/en.ini', 'lib/timetable_en.ini')
copyfile('css/timetable.css', 'lib/timetable.css')
filenames = ['src/timetable.php', 'src/day.php','src/helper.php','src/options.php','src/record.php']
with open('lib/timetable.php', 'w') as outfile:
    outfile.write('<?php\n\nnamespace timetable;\n');
    for fname in filenames:
        with open(fname) as infile:
            for line in infile.readlines()[3:]:
                outfile.write(line)