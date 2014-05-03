import java.util.*;

public class Solver {

    /**
     * Size (Width and Height) of the matrix
     */ 
    private static final int SIZE = 3;
    
    private SearchNode result;

    private class SearchNode implements Comparable<SearchNode> {
        private final Board board;
        private final int moves;
        private final SearchNode previous;
        private final int priority;

        private SearchNode(Board b, SearchNode p) {
            board = b;
            previous = p;
            if (previous == null) moves = 0;
            else moves = previous.moves + 1;
            priority = board.manhattan() + moves;
            // Property of A* algorithm.
            assert previous == null || priority >= previous.priority;
        }

        public int compareTo(SearchNode that)
        {   return this.priority - that.priority; }
    }

    // find a solution to the initial board (using the A* algorithm)
    public Solver(Board initial) {
        if (initial.isGoal()) {
            result = new SearchNode(initial, null);
        } else {
            result = solve(initial, initial.twin());
        }
    }

    private SearchNode step(MinPQ<SearchNode> pq) {
        SearchNode least = pq.delMin();
        for (Board neighbor: least.board.neighbors()) {
            if (least.previous == null || !neighbor.equals(least.previous.board))
                pq.insert(new SearchNode(neighbor, least));
        }
        return least;
    }

    private SearchNode solve(Board initial, Board twin) {
        SearchNode last;
        MinPQ<SearchNode> mainpq = new MinPQ<SearchNode>();
        //MinPQ<SearchNode> twinpq = new MinPQ<SearchNode>();        
        mainpq.insert(new SearchNode(initial, null));
        //twinpq.insert(new SearchNode(twin, null));        
        
        int cont = 0;
        
        while (true) {
            last = step(mainpq);
            if (last.board.isGoal()) return last;
            //if (step(twinpq).board.isGoal()) return null;

            System.out.println(last.board.toString());

            // TEST
            cont++;
            if (cont >= 1000) return null;
        }
    }

    // is the initial board solvable?
    public boolean isSolvable() {
        return result != null;
    }

    // min number of moves to solve initial board; -1 if no solution
    public int moves() {
        if (result != null)
            return result.moves;
        return -1;
    }

    // sequence of boards in a shortest solution; null if no solution
    public Iterable<Board> solution() {
        if (result == null)
            return null;
        Stack<Board> s = new Stack<Board>();
        for (SearchNode n = result; n != null; n = n.previous)
            s.push(n.board);
        return s;
    }

    // solve a slider puzzle (given below)
    public static void main(String[] args) {
        
        // TEST
        In in = new In(args[0]);
        //In in = new In();        

        // Read the number of tables
        int number_of_tables = in.readInt();

        // 
        int[][][] blocks = new int[number_of_tables][SIZE][SIZE];
        int[][][] goals = new int[number_of_tables][SIZE][SIZE];

        // Read a blank line
        in.readLine();
        in.readLine();

        for (int i=0; i < number_of_tables; i++) {

            List<String> names = new ArrayList<String>();
            String line = null;

            // Read the existing table layout
            for (int j = 0; j < SIZE; j++) {
                line = in.readLine();
                String []n = line.split(",");
                for (String s: n) {
                    if (!s.trim().equals("")) {
                        names.add(s.trim());                    
                    }
                }                
            }                

            //for (int j=0; j < names.size(); j++) {
            //    System.out.println("names: " + j + "\t names: " + names.get(j));
            //}

            // Initialize the initial table        
            int index = 1;
            for (int j = 0; j < SIZE; j++) {
                for (int k = 0; k < SIZE; k++) {
                        if (j==1 && k==1) {
                            blocks[i][j][k] = 0;
                        } else {
                            blocks[i][j][k] = index++;    
                        }
                }                
            }

            /*
            for (int j = 0; j < SIZE; j++) {
                for (int k = 0; k < SIZE; k++) {
                    System.out.print(blocks[i][j][k] + " ");
                }
                System.out.println("");
            }
            */
            
            // Read a blank line
            in.readLine();

            // Read the target table layout
            List<String> names_goal = new ArrayList<String>();
            for (int j = 0; j < SIZE; j++) {
                line = in.readLine();
                String []n = line.split(",");
                for (String s: n) {
                    names_goal.add(s.trim());
                }
            }

            /*
            for (int j=0; j < names_goal.size(); j++) {
                System.out.println("names_goal: " + j + "\t names_goal: " + names_goal.get(j));
            }

            for (int j=0; j < names_goal.size(); j++) {
                if (names_goal.get(j).equals("")) {
                    // index 0
                    System.out.println("Index: 0");
                } else {
                    int indexkk = names.indexOf(names_goal.get(j)) + 1;
                    System.out.println("Index: " + indexkk);
                }
            }
            */

            int ing = 0;
            for (int j = 0; j < SIZE; j++) {
                for (int k = 0; k < SIZE; k++) {

                    if (names_goal.get(ing).equals("")) {
                        goals[i][j][k] = 0;
                    } else {
                        goals[i][j][k] = names.indexOf(names_goal.get(ing)) + 1;
                    }
                    ing++;
                    
                }                
            }

            /*
            System.out.println("Goals:");
            for (int j = 0; j < SIZE; j++) {
                for (int k = 0; k < SIZE; k++) {
                    System.out.print(goals[i][j][k] + " ");
                }
                System.out.println("");
            }
            */

            // Read a blank line
            line = in.readLine();

        }        

        for (int i=0; i < number_of_tables; i++) {

            Board initial = new Board(blocks[i]);
            Target target = new Target(goals[i]);
            Solver solver = new Solver(initial);

            if (!solver.isSolvable())
                System.out.println("-1");
            else {
                System.out.println(solver.moves());
            }            
        }
    }
}

        /*
        Board initial = new Board(blocks[0]);
        StdOut.println(initial);
        
        // solve the puzzle
        Solver solver = new Solver(initial);

        // print solution to standard output
        if (!solver.isSolvable())
            StdOut.println("No solution possible");
        else {
            StdOut.println("Minimum number of moves = " + solver.moves());
            for (Board board : solver.solution())
                StdOut.println(board);                
        */
