#include <iostream>
#include <vector>
#include <set>
#include <unordered_set>
#include <unordered_map>

using namespace std;

typedef struct graph_node {
    string from;
    string to;
} graph_note_t;

bool khan_algo(vector<graph_note_t>& graph, vector<string>& order) {
    
    bool acyclic_graph = true;
    
        unordered_set<string> mapped_nodes;
    unordered_map<string,int> degrees;
    
    for (const auto& graph_node : graph) {
        
        mapped_nodes.insert(graph_node.from);
        mapped_nodes.insert(graph_node.to);
        
        degrees[graph_node.to]++;
    }
    
    while (true) {
        
        acyclic_graph = true;
        
        for (const auto& mapped_node : mapped_nodes) {
            
            if (degrees[mapped_node] == 0) {
                
                for (const auto& graph_node : graph) {
                    if (graph_node.from == mapped_node) {
                        degrees[graph_node.to]--;
                    }
                }
                
                order.push_back(mapped_node);
                
                acyclic_graph = false;
                
                degrees[mapped_node] = -1;
            }
        }
        
        if (acyclic_graph) {
            return true;
        }
    }
    
    return false;
}

int main() {
    
          vector<string> topological_order;
    vector<graph_note_t> graph_nodes;
    
    graph_nodes.push_back({ "t-shirt", "hoodie" });
    graph_nodes.push_back({ "underwear", "pants" });
    graph_nodes.push_back({ "pants", "shoes" });
    graph_nodes.push_back({ "socks", "shoes" });
    graph_nodes.push_back({ "hoodie", "backpack" });
    graph_nodes.push_back({ "backpack", "school" });
    graph_nodes.push_back({ "shoes", "school" });
    
    khan_algo(graph_nodes, topological_order);
    
    for (const auto& node : topological_order) {
        cout << node << " ";
    }
    
    cout << endl;
    
    return 0;
}
