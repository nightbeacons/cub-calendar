/* dquote.c

   Charles Jackson
*/

#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <string.h>
#include <sys/file.h>
#include <ctype.h>

#define   MAX_LINE 300


/* The random number generator 
   generates random numbers between 0 and n-num_quotes */





main ()
{

FILE *data_file;

   int lenline=0,  x,
       part1, part2, part3;
   long minute, second, index, clock;
   unsigned int seed, next;
   
   int i, h, press, got_one, count, cont_flag, skip, brk, num_quotes, test2, sw, pl1, pl2, ar, SPARC_flag,
   SPARC_length, temp1, temp2;

   char  title[MAX_LINE], line_from_file[MAX_LINE],*ma_ptr;

strcpy(title,"quotes.txt");


   data_file = fopen( title, "r");

printf("Content-type: text/html\n\n");



/* Figure out the number of quotes in the quote file. Assign this to num_quotes */

   num_quotes=0;

   while   ((fgets( line_from_file, MAX_LINE, data_file ) ) != NULL )
      if (strchr(line_from_file,'%') !=0) num_quotes++;

 


/* Determine a random quote to print (between 0 and numquote-1) */


    got_one = abs(((113*time(0))%(num_quotes)));


/*       printf("%d quotes\n", num_quotes);

         printf("%d is the ran num\n", got_one); 
 */

/* Rewind the quote file and print the quote */


rewind (data_file);

count=0;
while   ((fgets( line_from_file, MAX_LINE, data_file ) ) != NULL && (count < got_one) )
      if (strchr(line_from_file,'%') !=0) count++;



while (strchr(line_from_file,'%') ==0) {

    printf("%s",line_from_file);
    fgets( line_from_file, MAX_LINE, data_file );
}


   fclose(data_file);

 
 
} /* end of main() */

